#include "Employee.h"
#include <iomanip>

Employee::Employee(int id, const std::string& nombre, const std::string& apellido,
                   double salarioBase, const std::string& departamento)
    : id(id), nombre(nombre), apellido(apellido),
      salarioBase(salarioBase), departamento(departamento) {}

void Employee::mostrarInfo() const {
    std::cout << "\n┌─────────────────────────────────────────┐\n";
    std::cout << "│ ID: " << std::setw(36) << std::left << id << "│\n";
    std::cout << "│ Nombre: " << std::setw(32) << std::left << (nombre + " " + apellido) << "│\n";
    std::cout << "│ Tipo: " << std::setw(34) << std::left << getTipo() << "│\n";
    std::cout << "│ Departamento: " << std::setw(26) << std::left << departamento << "│\n";
    std::cout << "│ Salario Base: $" << std::setw(24) << std::left << std::fixed << std::setprecision(2) << salarioBase << "│\n";
    std::cout << "│ Salario Total: $" << std::setw(23) << std::left << calcularSalarioTotal() << "│\n";
}
