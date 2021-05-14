<?php
session_start();	
require_once 'controller/product-controller.php';
require_once 'controller/user-controller.php';
require_once 'controller/category-controller.php';
require_once 'controller/cart-controller.php';
require_once 'controller/orders-controller.php';


if (isset ($_GET['action'])){

	switch ($_GET['action']) {


		// Utilisateur
		case 'deconnexion':
			deconnectUser();
			break;

		case 'monCompte':
			showAccountInfo();
			break;

		case 'updateUser':
			updateUser();
			break;

		case 'signup':
			signup();
			break;

		case 'login':
			login();
			break;
		
		case 'showClientAdmin':
			showUsers();
			break;
			
		case 'deleteUser':
			deleteUser();
			break;


		

		// Produits 
		case 'deleteProduct':
			deleteProduct();
			break;

		case 'updateProductForm':
			showUpdateProductForm();
			break;

		case 'updateProduct':
			updateProduct();
			break;	
			
		case 'productAdmin':
			listProductsTab();
			break;

		case 'productDetails':
			showDetailedProduct();
			break;

		case 'addProduct': 
			addProduct();
			break;


		// Categories
		case 'categoriesAdmin':
			viewCategoriesTab();
			break;
		
		case 'updateCategory':
			updateCategory();
			break;

		case 'deleteCategory':
			deleteCategory();
			break;

		case 'addCategory':
			addCategory();
			break;


		// Panier
		case 'addToCart':
			addToCart();
			break;
			
		case 'showCart':
			showCart();
			break;

		case 'deleteCart':
			deleteCart();
			break;

		case 'updateProductInCart':
			updateProductInCart();
			break;



			
		// Commandes

		case 'OrdersAdmin':
			viewOrdersTab();
			break;
		case 'orderDetails':
			viewDetailedOrder();
			break;
		case 'orderCart':
			placeOrder();
			break;
		case 'updateOrder':
			updateOrder();
			break;



		// Par défaut 
		default:
			listProducts();
			break;
	}	
}
else {
	listProducts();
}



?>