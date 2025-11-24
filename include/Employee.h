#ifndef EMPLOYEE_H
#define EMPLOYEE_H

#include <string>
#include <iostream>

/**
 * Clase base Employee - Representa un empleado genérico
 * Demuestra: encapsulación, métodos virtuales, abstracción
 */
class Employee {
protected:
    int id;
    std::string nombre;
    std::string apellido;
    double salarioBase;
    std::string departamento;

public:
    // Constructor
    Employee(int id, const std::string& nombre, const std::string& apellido,
             double salarioBase, const std::string& departamento);

    // Destructor virtual (importante para herencia)
    virtual ~Employee() = default;

    // Métodos virtuales puros - hacen la clase abstracta
    virtual double calcularSalarioTotal() const = 0;
    virtual std::string getTipo() const = 0;
    virtual void mostrarInfo() const;

    // Serialización para guardar en archivo
    virtual std::string serializar() const = 0;

    // Getters
    int getId() const { return id; }
    std::string getNombre() const { return nombre; }
    std::string getApellido() const { return apellido; }
    double getSalarioBase() const { return salarioBase; }
    std::string getDepartamento() const { return departamento; }

    // Setters
    void setSalarioBase(double nuevoSalario) { salarioBase = nuevoSalario; }
    void setDepartamento(const std::string& dept) { departamento = dept; }
};

#endif // EMPLOYEE_H
