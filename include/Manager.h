#ifndef MANAGER_H
#define MANAGER_H

#include "Employee.h"

/**
 * Clase Manager - Hereda de Employee
 * Representa un manager con equipo a cargo y bonus de gestión
 */
class Manager : public Employee {
private:
    int equipoACargo;
    double bonusGestion;

public:
    Manager(int id, const std::string& nombre, const std::string& apellido,
            double salarioBase, const std::string& departamento,
            int equipoACargo, double bonusGestion);

    // Implementación de métodos virtuales
    double calcularSalarioTotal() const override;
    std::string getTipo() const override { return "Manager"; }
    void mostrarInfo() const override;
    std::string serializar() const override;

    // Métodos específicos
    int getEquipoACargo() const { return equipoACargo; }
    void setEquipoACargo(int equipo) { equipoACargo = equipo; }
    double getBonusGestion() const { return bonusGestion; }
    void setBonusGestion(double bonus) { bonusGestion = bonus; }
};

#endif // MANAGER_H
