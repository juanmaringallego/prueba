#ifndef EMPLOYEE_MANAGER_H
#define EMPLOYEE_MANAGER_H

#include "Employee.h"
#include "Developer.h"
#include "Manager.h"
#include <memory>
#include <vector>
#include <map>
#include <string>

/**
 * Clase EmployeeManager - Sistema de gestión de empleados
 * Demuestra: smart pointers, contenedores STL, manejo de archivos
 */
class EmployeeManager {
private:
    // Uso de smart pointers para gestión automática de memoria
    std::vector<std::unique_ptr<Employee>> empleados;
    int siguienteId;
    std::string archivoGuardado;

    // Métodos privados auxiliares
    Employee* buscarPorId(int id);
    void cargarDesdeArchivo();

public:
    EmployeeManager(const std::string& archivo = "data/empleados.txt");
    ~EmployeeManager();

    // Operaciones CRUD
    void agregarDeveloper(const std::string& nombre, const std::string& apellido,
                         double salarioBase, const std::string& departamento,
                         const std::vector<std::string>& lenguajes, double bonus);

    void agregarManager(const std::string& nombre, const std::string& apellido,
                       double salarioBase, const std::string& departamento,
                       int equipoACargo, double bonus);

    bool eliminarEmpleado(int id);
    void listarTodosEmpleados() const;
    void buscarEmpleado(int id) const;
    bool modificarSalario(int id, double nuevoSalario);

    // Consultas y estadísticas
    void empleadosPorDepartamento() const;
    double calcularNominaTotal() const;
    void guardarEnArchivo() const;

    // Utilidades
    int getCantidadEmpleados() const { return empleados.size(); }
};

#endif // EMPLOYEE_MANAGER_H
