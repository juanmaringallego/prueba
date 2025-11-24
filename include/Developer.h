#ifndef DEVELOPER_H
#define DEVELOPER_H

#include "Employee.h"
#include <vector>

/**
 * Clase Developer - Hereda de Employee
 * Representa un desarrollador con lenguajes de programación y bonus
 */
class Developer : public Employee {
private:
    std::vector<std::string> lenguajes;
    double bonusProyectos;

public:
    Developer(int id, const std::string& nombre, const std::string& apellido,
              double salarioBase, const std::string& departamento,
              const std::vector<std::string>& lenguajes, double bonusProyectos);

    // Implementación de métodos virtuales
    double calcularSalarioTotal() const override;
    std::string getTipo() const override { return "Developer"; }
    void mostrarInfo() const override;
    std::string serializar() const override;

    // Métodos específicos
    void agregarLenguaje(const std::string& lenguaje);
    const std::vector<std::string>& getLenguajes() const { return lenguajes; }
    double getBonusProyectos() const { return bonusProyectos; }
    void setBonusProyectos(double bonus) { bonusProyectos = bonus; }
};

#endif // DEVELOPER_H
