#include "Developer.h"
#include <sstream>
#include <iomanip>

Developer::Developer(int id, const std::string& nombre, const std::string& apellido,
                     double salarioBase, const std::string& departamento,
                     const std::vector<std::string>& lenguajes, double bonusProyectos)
    : Employee(id, nombre, apellido, salarioBase, departamento),
      lenguajes(lenguajes), bonusProyectos(bonusProyectos) {}

double Developer::calcularSalarioTotal() const {
    // Salario base + bonus de proyectos + bonus por cada lenguaje
    return salarioBase + bonusProyectos + (lenguajes.size() * 500.0);
}

void Developer::mostrarInfo() const {
    Employee::mostrarInfo();
    std::cout << "│ Bonus Proyectos: $" << std::setw(20) << std::left << std::fixed << std::setprecision(2) << bonusProyectos << "│\n";
    std::cout << "│ Lenguajes (" << lenguajes.size() << "): ";

    std::string langs;
    for (size_t i = 0; i < lenguajes.size(); ++i) {
        langs += lenguajes[i];
        if (i < lenguajes.size() - 1) langs += ", ";
    }
    std::cout << std::setw(28 - std::to_string(lenguajes.size()).length()) << std::left << langs << "│\n";
    std::cout << "└─────────────────────────────────────────┘\n";
}

std::string Developer::serializar() const {
    std::ostringstream oss;
    oss << "DEV|" << id << "|" << nombre << "|" << apellido << "|"
        << salarioBase << "|" << departamento << "|" << bonusProyectos << "|";

    for (size_t i = 0; i < lenguajes.size(); ++i) {
        oss << lenguajes[i];
        if (i < lenguajes.size() - 1) oss << ",";
    }

    return oss.str();
}

void Developer::agregarLenguaje(const std::string& lenguaje) {
    lenguajes.push_back(lenguaje);
}
