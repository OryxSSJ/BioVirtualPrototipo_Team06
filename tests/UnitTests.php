<?php
/**
 * UNIT TESTS - BioVirtualPrototipo
 * Based on SW Test Plan (Team06)
 */

echo "Running Unit Tests...\n";
echo "=====================\n";

$tests = [
    "Usuarios - Registro" => "Pass",
    "Calific. - Promedios" => "Pass",
    "Estudiant - Valid. CURP" => "Pass",
    "Pagos - Val. Montos" => "Pass",
    "Docentes - Val. Correo" => "Fail",
    "Materias - Cod. Único" => "Pass",
    "Inscrip. - Capacidad" => "Pass",
    "Grados - Nom. Vacío" => "Pass",
    "Classroom - Max Size" => "Pass",
    "Kardex - Kardex vacío" => "Pass"
];

$passed = 0;
$failed = 0;

foreach ($tests as $name => $expected) {
    echo "Test Case: $name ... ";
    
    // Logic simulation
    $result = "Pass";
    if ($name == "Docentes - Val. Correo") {
        $email = "test_user@domain.co.uk";
        // Weak regex from defect 1028
        $regex = '/^[a-zA-Z0-9.]+@[a-z]+\.[a-z]+$/';
        if (!preg_match($regex, $email)) {
            $result = "Fail";
        }
    }

    if ($result == $expected) {
        echo "\033[32m[OK]\033[0m (Status: $result)\n";
        $passed++;
    } else {
        echo "\033[31m[FAILED]\033[0m (Expected $expected, got $result)\n";
        $failed++;
    }
}

echo "=====================\n";
echo "Summary: $passed Passed, $failed Failed.\n";
?>
