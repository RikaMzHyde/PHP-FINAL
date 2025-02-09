<?php
header('Content-Type: application/json'); //Respuesta será en JSON

//Si no está iniciada, inicia la sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//Inicializa el carrito si no existe en la sesión
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = []; //Como array vacío
}
//Require de las cosas qye vamos a necesitar
require_once('cart_functions.php');
require_once('apiBD.php');


//Obtener el cuerpo de la solicitud en JSON y pasarlo a array asociativo
$requestPayload = json_decode(file_get_contents('php://input'), true);

//Rutas de la API según el tipo de solicitud
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //Si es GET, devuelve la lista artículos en el carrito
    echo json_encode(loadCartItems());
    exit;
}

//Si es POST y hay una acción definida
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($requestPayload['action'])) {
    //Determina qué acción hacer según el valor de "action"
    switch ($requestPayload['action']) {
        //Acción de agregar al carrito
        case 'add':
            if (isset($requestPayload['code'])) {
                $code = $requestPayload['code']; //Obtiene código de prod

                // Asegurar que $_SESSION['cart'] es un array
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                //Indicador para saber si el producto ya lo tenemos en el carrito
                $itemFound = false;

                //Buscar si el producto ya existe en el carrito
                foreach ($_SESSION['cart'] as &$item) {
                    if ($item['code'] === $code) {
                        $item['quantity'] += 1; //Si lo encuentra incrementar la cantidad
                        $itemFound = true; //Y lo marca como encontrado
                        break;
                    }
                }

                //Si el producto no está en el carrito, añadirlo
                if (!$itemFound) {
                    $_SESSION['cart'][] = [
                        'code' => $code,
                        'quantity' => 1
                    ];
                }
                //Mensaje JSON para confirmar que se ha incrementado la cantidad del producto
                echo json_encode( ['success' => true, 'message' => 'Cantidad incrementada', 'cart' => $_SESSION['cart']]);
            } else {
                echo json_encode(['error' => 'Faltan parámetros para agregar']);
            }
            break;
        //Acción de eliminar del carrito
        case 'remove':
            if (isset($requestPayload['code'])) {
                $code = $requestPayload['code']; //Obtiene código de prod

                // Asegurar que $_SESSION['cart'] es un array
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }
                //Recorre el carrito buscando el producto con el código especificado
                foreach ($_SESSION['cart'] as $index => &$item) {
                    if ($item['code'] === $code) {
                        $item['quantity'] -= 1; //Decrementar la cantidad
                        if ($item['quantity'] <= 0) {
                            unset($_SESSION['cart'][$index]); //Eliminar del carruti si la cantidad es 0
                        }
                        break;
                    }
                }

                // Reindexar el array para evitar huecos en los índices
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                //Mensaje JSON para confirmar que se ha incrementado la cantidad del producto
                echo json_encode(['success' => true, 'message' => 'Cantidad decrementada', 'cart' => $_SESSION['cart']]);
            } else {
                echo json_encode(['error' => 'Faltan parámetros para eliminar']);
            }
            break;
        //Acción de vaciar un producto del carrito
        case 'clear':
            if (isset($requestPayload['code'])) {
                $code = $requestPayload['code']; //Obtiene código de prod

                // Asegurar que $_SESSION['cart'] es un array
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }
                //Recorre el carrito buscando el producto con el código especificado
                foreach ($_SESSION['cart'] as $index => &$item) {
                    if ($item['code'] === $code) {
                        unset($_SESSION['cart'][$index]); //Elimina prod de carrito
                        break;
                    }
                }

                //Reindexar el array para evitar huecos en los índices
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                //Mensaje JSON para confirmar que se ha incrementado la cantidad del producto
                echo json_encode(['success' => true, 'message' => 'Cantidad decrementada', 'cart' => $_SESSION['cart']]);
            } else {
                echo json_encode(['error' => 'Faltan parámetros para eliminar']);
            }
            break;
        default:
            echo json_encode(['error' => 'Acción no válida']);
            break;
    }
    //Si la solicitud GET incluye la acción "view", se muestra el carrito
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'view') {
    // Ver el carrito
    echo json_encode(['cart' => $_SESSION['cart']]);
} else {
    echo json_encode(['error' => 'Método o acción no soportados']);
}
?>