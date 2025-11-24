#include "Manager.h"
#include <sstream>
#include <iomanip>

Manager::Manager(int id, const std::string& nombre, const std::string& apellido,
                 double salarioBase, const std::string& departamento,
                 int equipoACargo, double bonusGestion)
    : Employee(id, nombre, apellido, salarioBase, departamento),
      equipoACargo(equipoACargo), bonusGestion(bonusGestion) {}

double Manager::calcularSalarioTotal() const {
    // Salario base + bonus de gestión + bonus por cada persona en el equipo
    return salarioBase + bonusGestion + (equipoACargo * 300.0);
}

void Manager::mostrarInfo() const {
    Employee::mostrarInfo();
    std::cout << "│ Equipo a Cargo: " << std::setw(24) << std::left << equipoACargo << "│\n";
    std::cout << "│ Bonus Gestión: $" << std::setw(23) << std::left << std::fixed << std::setprecision(2) << bonusGestion << "│\n";
    std::cout << "└─────────────────────────────────────────┘\n";
}

std::string Manager::serializar() const {
    std::ostringstream oss;
    oss << "MGR|" << id << "|" << nombre << "|" << apellido << "|"
        << salarioBase << "|" << departamento << "|" << equipoACargo << "|"
        << bonusGestion;
    return oss.str();
}
