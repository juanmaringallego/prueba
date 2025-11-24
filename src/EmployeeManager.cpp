#include "EmployeeManager.h"
#include <fstream>
#include <sstream>
#include <algorithm>
#include <iostream>
#include <iomanip>

EmployeeManager::EmployeeManager(const std::string& archivo)
    : siguienteId(1), archivoGuardado(archivo) {
    cargarDesdeArchivo();
}

EmployeeManager::~EmployeeManager() {
    guardarEnArchivo();
}

void EmployeeManager::cargarDesdeArchivo() {
    std::ifstream archivo(archivoGuardado);
    if (!archivo.is_open()) {
        std::cout << "⚠️  Archivo no encontrado. Iniciando con base de datos vacía.\n";
        return;
    }

    std::string linea;
    while (std::getline(archivo, linea)) {
        std::istringstream iss(linea);
        std::string tipo, campo;
        std::vector<std::string> campos;

        while (std::getline(iss, campo, '|')) {
            campos.push_back(campo);
        }

        if (campos.size() < 6) continue;

        tipo = campos[0];
        int id = std::stoi(campos[1]);
        std::string nombre = campos[2];
        std::string apellido = campos[3];
        double salarioBase = std::stod(campos[4]);
        std::string departamento = campos[5];

        if (tipo == "DEV" && campos.size() >= 8) {
            double bonus = std::stod(campos[6]);
            std::vector<std::string> lenguajes;

            std::istringstream langStream(campos[7]);
            std::string lang;
            while (std::getline(langStream, lang, ',')) {
                lenguajes.push_back(lang);
            }

            empleados.push_back(std::make_unique<Developer>(
                id, nombre, apellido, salarioBase, departamento, lenguajes, bonus));
        } else if (tipo == "MGR" && campos.size() >= 8) {
            int equipo = std::stoi(campos[6]);
            double bonus = std::stod(campos[7]);

            empleados.push_back(std::make_unique<Manager>(
                id, nombre, apellido, salarioBase, departamento, equipo, bonus));
        }

        if (id >= siguienteId) {
            siguienteId = id + 1;
        }
    }

    archivo.close();
    std::cout << "✅ Cargados " << empleados.size() << " empleados desde archivo.\n";
}

void EmployeeManager::guardarEnArchivo() const {
    std::ofstream archivo(archivoGuardado);
    if (!archivo.is_open()) {
        std::cerr << "❌ Error al abrir archivo para guardar.\n";
        return;
    }

    for (const auto& emp : empleados) {
        archivo << emp->serializar() << "\n";
    }

    archivo.close();
}

Employee* EmployeeManager::buscarPorId(int id) {
    for (auto& emp : empleados) {
        if (emp->getId() == id) {
            return emp.get();
        }
    }
    return nullptr;
}

void EmployeeManager::agregarDeveloper(const std::string& nombre, const std::string& apellido,
                                       double salarioBase, const std::string& departamento,
                                       const std::vector<std::string>& lenguajes, double bonus) {
    empleados.push_back(std::make_unique<Developer>(
        siguienteId++, nombre, apellido, salarioBase, departamento, lenguajes, bonus));
    std::cout << "✅ Developer agregado con ID: " << (siguienteId - 1) << "\n";
}

void EmployeeManager::agregarManager(const std::string& nombre, const std::string& apellido,
                                     double salarioBase, const std::string& departamento,
                                     int equipoACargo, double bonus) {
    empleados.push_back(std::make_unique<Manager>(
        siguienteId++, nombre, apellido, salarioBase, departamento, equipoACargo, bonus));
    std::cout << "✅ Manager agregado con ID: " << (siguienteId - 1) << "\n";
}

bool EmployeeManager::eliminarEmpleado(int id) {
    auto it = std::remove_if(empleados.begin(), empleados.end(),
                            [id](const std::unique_ptr<Employee>& emp) {
                                return emp->getId() == id;
                            });

    if (it != empleados.end()) {
        empleados.erase(it, empleados.end());
        std::cout << "✅ Empleado con ID " << id << " eliminado.\n";
        return true;
    }

    std::cout << "❌ No se encontró empleado con ID " << id << "\n";
    return false;
}

void EmployeeManager::listarTodosEmpleados() const {
    if (empleados.empty()) {
        std::cout << "📭 No hay empleados registrados.\n";
        return;
    }

    std::cout << "\n═══════════════════════════════════════════════\n";
    std::cout << "         LISTADO DE EMPLEADOS\n";
    std::cout << "═══════════════════════════════════════════════\n";

    for (const auto& emp : empleados) {
        emp->mostrarInfo();
    }
}

void EmployeeManager::buscarEmpleado(int id) const {
    for (const auto& emp : empleados) {
        if (emp->getId() == id) {
            emp->mostrarInfo();
            return;
        }
    }
    std::cout << "❌ No se encontró empleado con ID " << id << "\n";
}

bool EmployeeManager::modificarSalario(int id, double nuevoSalario) {
    Employee* emp = buscarPorId(id);
    if (emp) {
        emp->setSalarioBase(nuevoSalario);
        std::cout << "✅ Salario actualizado para empleado ID " << id << "\n";
        return true;
    }
    std::cout << "❌ No se encontró empleado con ID " << id << "\n";
    return false;
}

void EmployeeManager::empleadosPorDepartamento() const {
    std::map<std::string, int> departamentos;

    for (const auto& emp : empleados) {
        departamentos[emp->getDepartamento()]++;
    }

    std::cout << "\n═══════════════════════════════════════════════\n";
    std::cout << "      EMPLEADOS POR DEPARTAMENTO\n";
    std::cout << "═══════════════════════════════════════════════\n";

    for (const auto& [dept, count] : departamentos) {
        std::cout << "  " << std::setw(20) << std::left << dept << " : " << count << " empleados\n";
    }
}

double EmployeeManager::calcularNominaTotal() const {
    double total = 0.0;
    for (const auto& emp : empleados) {
        total += emp->calcularSalarioTotal();
    }
    return total;
}
