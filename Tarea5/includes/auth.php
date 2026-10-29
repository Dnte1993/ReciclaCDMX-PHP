<?php
// Iniciar o reanudar la sesión en cualquier página que cargue este archivo
session_start();

// Función que simula una base de datos con los usuarios y sus roles[cite: 42]
function obtenerUsuarios() {
    return [
        "usuario@reciclacdmx.com" => [
            "password" => "12345",
            "nombre" => "Ciudadano",
            "rol" => "registrado"
        ],
        "admin@reciclacdmx.com" => [
            "password" => "admin123",
            "nombre" => "Administrador",
            "rol" => "admin"
        ]
    ];
}

// Función auxiliar para verificar si hay una sesión activa[cite: 42]
function estaLogueado() {
    return isset($_SESSION['usuario']);
}
?>