#include "EmployeeManager.h"
#include <iostream>
#include <limits>
#include <vector>
#include <iomanip>

// Función para limpiar el buffer de entrada
void limpiarBuffer() {
    std::cin.clear();
    std::cin.ignore(std::numeric_limits<std::streamsize>::max(), '\n');
}

// Función para mostrar el menú principal
void mostrarMenu() {
    std::cout << "\n╔═══════════════════════════════════════════════╗\n";
    std::cout << "║    SISTEMA DE GESTIÓN DE EMPLEADOS v1.0      ║\n";
    std::cout << "╠═══════════════════════════════════════════════╣\n";
    std::cout << "║  1. Agregar Developer                         ║\n";
    std::cout << "║  2. Agregar Manager                           ║\n";
    std::cout << "║  3. Listar todos los empleados                ║\n";
    std::cout << "║  4. Buscar empleado por ID                    ║\n";
    std::cout << "║  5. Modificar salario                         ║\n";
    std::cout << "║  6. Eliminar empleado                         ║\n";
    std::cout << "║  7. Ver empleados por departamento            ║\n";
    std::cout << "║  8. Calcular nómina total                     ║\n";
    std::cout << "║  9. Guardar y salir                           ║\n";
    std::cout << "╚═══════════════════════════════════════════════╝\n";
    std::cout << "Seleccione una opción: ";
}

void agregarDeveloper(EmployeeManager& manager) {
    std::string nombre, apellido, departamento, lenguaje;
    double salarioBase, bonus;
    int numLenguajes;

    std::cout << "\n--- Agregar Developer ---\n";
    std::cout << "Nombre: ";
    std::cin >> nombre;
    std::cout << "Apellido: ";
    std::cin >> apellido;
    std::cout << "Salario base: $";
    std::cin >> salarioBase;
    limpiarBuffer();
    std::cout << "Departamento: ";
    std::getline(std::cin, departamento);

    std::cout << "¿Cuántos lenguajes domina?: ";
    std::cin >> numLenguajes;
    limpiarBuffer();

    std::vector<std::string> lenguajes;
    for (int i = 0; i < numLenguajes; ++i) {
        std::cout << "Lenguaje " << (i + 1) << ": ";
        std::getline(std::cin, lenguaje);
        lenguajes.push_back(lenguaje);
    }

    std::cout << "Bonus por proyectos: $";
    std::cin >> bonus;

    manager.agregarDeveloper(nombre, apellido, salarioBase, departamento, lenguajes, bonus);
}

void agregarManager(EmployeeManager& manager) {
    std::string nombre, apellido, departamento;
    double salarioBase, bonus;
    int equipo;

    std::cout << "\n--- Agregar Manager ---\n";
    std::cout << "Nombre: ";
    std::cin >> nombre;
    std::cout << "Apellido: ";
    std::cin >> apellido;
    std::cout << "Salario base: $";
    std::cin >> salarioBase;
    limpiarBuffer();
    std::cout << "Departamento: ";
    std::getline(std::cin, departamento);
    std::cout << "Personas en el equipo: ";
    std::cin >> equipo;
    std::cout << "Bonus de gestión: $";
    std::cin >> bonus;

    manager.agregarManager(nombre, apellido, salarioBase, departamento, equipo, bonus);
}

void buscarEmpleado(EmployeeManager& manager) {
    int id;
    std::cout << "\nIngrese ID del empleado: ";
    std::cin >> id;
    manager.buscarEmpleado(id);
}

void modificarSalario(EmployeeManager& manager) {
    int id;
    double nuevoSalario;
    std::cout << "\nIngrese ID del empleado: ";
    std::cin >> id;
    std::cout << "Nuevo salario base: $";
    std::cin >> nuevoSalario;
    manager.modificarSalario(id, nuevoSalario);
}

void eliminarEmpleado(EmployeeManager& manager) {
    int id;
    std::cout << "\nIngrese ID del empleado a eliminar: ";
    std::cin >> id;
    manager.eliminarEmpleado(id);
}

void calcularNomina(EmployeeManager& manager) {
    double total = manager.calcularNominaTotal();
    std::cout << "\n═══════════════════════════════════════════════\n";
    std::cout << "  NÓMINA TOTAL DE LA EMPRESA: $" << std::fixed << std::setprecision(2) << total << "\n";
    std::cout << "  Total de empleados: " << manager.getCantidadEmpleados() << "\n";
    std::cout << "═══════════════════════════════════════════════\n";
}

int main() {
    EmployeeManager manager("data/empleados.txt");

    int opcion;
    bool continuar = true;

    std::cout << "\n🚀 Bienvenido al Sistema de Gestión de Empleados\n";

    while (continuar) {
        mostrarMenu();
        std::cin >> opcion;

        // Validación de entrada
        if (std::cin.fail()) {
            limpiarBuffer();
            std::cout << "❌ Opción inválida. Intente nuevamente.\n";
            continue;
        }

        switch (opcion) {
            case 1:
                agregarDeveloper(manager);
                break;
            case 2:
                agregarManager(manager);
                break;
            case 3:
                manager.listarTodosEmpleados();
                break;
            case 4:
                buscarEmpleado(manager);
                break;
            case 5:
                modificarSalario(manager);
                break;
            case 6:
                eliminarEmpleado(manager);
                break;
            case 7:
                manager.empleadosPorDepartamento();
                break;
            case 8:
                calcularNomina(manager);
                break;
            case 9:
                std::cout << "\n💾 Guardando datos...\n";
                manager.guardarEnArchivo();
                std::cout << "👋 ¡Hasta luego!\n\n";
                continuar = false;
                break;
            default:
                std::cout << "❌ Opción inválida. Intente nuevamente.\n";
        }
    }

    return 0;
}
