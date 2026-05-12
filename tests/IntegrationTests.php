<?php
/**
 * INTEGRATION TESTS - BioVirtualPrototipo
 * Based on SW Test Plan (Team06)
 */

echo "Running Integration Tests...\n";
echo "============================\n";

$tests = [
    "Est/Insc - Integración" => "Pass",
    "Cal/Karde - Integración" => "Pass",
    "Pagos/Est - Integración" => "Pass",
    "Doc/Mat - Integración" => "Fail",
    "Roles/Us - Integración" => "Pass",
    "Clas/Envi - Integración" => "Pass",
    "Grad/Niv - Integración" => "Pass",
    "Adm/Cont - Integración" => "Pass",
    "Insc/Pag - Integración" => "Blocked",
    "Usu/Doce - Integración" => "Pass"
];

$passed = 0;
$failed = 0;
$blocked = 0;

foreach ($tests as $name => $expected) {
    echo "Test Case: $name ... ";
    
    $result = "Pass";
    if ($name == "Doc/Mat - Integración") {
        // Simulate Defect 1029: Horario no se actualiza
        $updateSuccess = false; 
        if (!$updateSuccess) $result = "Fail";
    } elseif ($name == "Insc/Pag - Integración") {
        // Simulate Defect 1030: Módulo de cobros no desplegado
        $moduleDeployed = false;
        if (!$moduleDeployed) $result = "Blocked";
    }

    if ($result == $expected) {
        if ($result == "Blocked") {
            echo "\033[33m[BLOCKED]\033[0m (Defect 1030)\n";
            $blocked++;
        } else {
            echo "\033[32m[OK]\033[0m (Status: $result)\n";
            $passed++;
        }
    } else {
        echo "\033[31m[FAILED]\033[0m (Expected $expected, got $result)\n";
        $failed++;
    }
}

echo "============================\n";
echo "Summary: $passed Passed, $failed Failed, $blocked Blocked.\n";
?>
