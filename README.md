# 🚀 Sistema de Gestión de Empleados - Proyecto Demo C++

## 📋 Descripción

Este es un **proyecto de entrenamiento en C++** que simula un sistema empresarial real de gestión de empleados. Está diseñado para demostrar conceptos avanzados de C++ que encontrarás en entornos profesionales.

## 🎯 Conceptos de C++ Demostrados

### 1. **Programación Orientada a Objetos (POO)**
- ✅ **Clases y Encapsulación**: Atributos privados/protegidos con getters/setters
- ✅ **Herencia**: `Developer` y `Manager` heredan de `Employee`
- ✅ **Polimorfismo**: Métodos virtuales (`calcularSalarioTotal()`, `mostrarInfo()`)
- ✅ **Clases Abstractas**: `Employee` con métodos virtuales puros
- ✅ **Destructores Virtuales**: Gestión correcta de memoria en jerarquías

### 2. **C++ Moderno (C++11/14/17)**
- ✅ **Smart Pointers**: `std::unique_ptr` para gestión automática de memoria
- ✅ **Range-based for loops**: Iteración moderna de contenedores
- ✅ **Auto type deduction**: Inferencia de tipos
- ✅ **Lambda functions**: En algoritmos como `std::remove_if`
- ✅ **Override keyword**: Seguridad en métodos virtuales

### 3. **STL (Standard Template Library)**
- ✅ **Contenedores**: `std::vector`, `std::map`
- ✅ **Algoritmos**: `std::remove_if`, `std::getline`
- ✅ **Strings**: `std::string`, `std::ostringstream`
- ✅ **Iteradores**: Uso avanzado con algoritmos

### 4. **Gestión de Archivos**
- ✅ **Serialización**: Guardar objetos en formato texto
- ✅ **Deserialización**: Cargar objetos desde archivos
- ✅ **Persistencia**: Datos sobreviven entre ejecuciones

### 5. **Buenas Prácticas Empresariales**
- ✅ **Separación de archivos**: Headers (.h) e implementación (.cpp)
- ✅ **Include Guards**: Prevención de inclusiones múltiples
- ✅ **Const Correctness**: Métodos const donde corresponde
- ✅ **RAII**: Gestión automática de recursos
- ✅ **Error Handling**: Validación de entrada y manejo de errores

## 📁 Estructura del Proyecto

```
prueba/
│
├── include/              # Archivos de cabecera (.h)
│   ├── Employee.h        # Clase base abstracta
│   ├── Developer.h       # Clase derivada para desarrolladores
│   ├── Manager.h         # Clase derivada para managers
│   └── EmployeeManager.h # Sistema de gestión
│
├── src/                  # Implementaciones (.cpp)
│   ├── Employee.cpp
│   ├── Developer.cpp
│   ├── Manager.cpp
│   ├── EmployeeManager.cpp
│   └── main.cpp          # Punto de entrada del programa
│
├── data/                 # Datos persistentes
│   └── empleados.txt     # Base de datos de empleados
│
├── Makefile              # Sistema de compilación
└── README.md             # Este archivo
```

## 🛠️ Compilación y Ejecución

### Requisitos Previos
- Compilador C++ compatible con C++17 (g++ 7+, clang++ 5+)
- Make (opcional, pero recomendado)

### Compilar el Proyecto

```bash
# Opción 1: Usando Make (recomendado)
make              # Compila en modo release
make debug        # Compila con símbolos de depuración
make clean        # Limpia archivos compilados
make help         # Muestra ayuda

# Opción 2: Compilación manual
g++ -std=c++17 -Iinclude src/*.cpp -o employee_system
```

### Ejecutar el Programa

```bash
# Con Make
make run

# O directamente
./bin/employee_system
```

## 🎮 Uso del Sistema

El programa presenta un menú interactivo con las siguientes opciones:

1. **Agregar Developer**: Crea un empleado tipo desarrollador con lenguajes
2. **Agregar Manager**: Crea un empleado tipo manager con equipo
3. **Listar empleados**: Muestra todos los empleados registrados
4. **Buscar por ID**: Encuentra un empleado específico
5. **Modificar salario**: Actualiza el salario base de un empleado
6. **Eliminar empleado**: Elimina un empleado del sistema
7. **Ver por departamento**: Estadísticas de empleados por área
8. **Calcular nómina**: Total de salarios a pagar
9. **Guardar y salir**: Persiste los datos y cierra el programa

## 💡 Conceptos Clave para Estudiar

### 1. Herencia y Polimorfismo

```cpp
// Clase base abstracta
class Employee {
    virtual double calcularSalarioTotal() const = 0;  // Virtual pura
    virtual ~Employee() = default;                     // Destructor virtual
};

// Clases derivadas implementan el método
class Developer : public Employee {
    double calcularSalarioTotal() const override {
        return salarioBase + bonusProyectos + (lenguajes.size() * 500);
    }
};
```

### 2. Smart Pointers (Gestión Automática de Memoria)

```cpp
// En lugar de punteros raw (Employee*)
std::vector<std::unique_ptr<Employee>> empleados;

// Creación de objetos
empleados.push_back(std::make_unique<Developer>(...));

// No necesitas delete - se libera automáticamente
```

### 3. Contenedores STL

```cpp
// Vector para colecciones dinámicas
std::vector<std::string> lenguajes;

// Map para asociaciones clave-valor
std::map<std::string, int> departamentos;
```

### 4. Algoritmos STL

```cpp
// Eliminar elementos con predicado
auto it = std::remove_if(empleados.begin(), empleados.end(),
    [id](const std::unique_ptr<Employee>& emp) {
        return emp->getId() == id;
    });
empleados.erase(it, empleados.end());
```

## 📚 Ejercicios Propuestos

Para practicar más, intenta implementar:

1. **Nueva clase de empleado**: `Intern` (pasante) con fecha de fin
2. **Búsqueda avanzada**: Por nombre, departamento, rango salarial
3. **Ordenamiento**: Listar empleados por salario, nombre, etc.
4. **Reportes**: Generar informes en formato CSV o JSON
5. **Validaciones**: Salarios negativos, IDs duplicados, etc.
6. **Excepciones**: Usar try-catch para errores de archivo
7. **Templates**: Hacer el sistema genérico para otros tipos

## 🔍 Preguntas de Entrevista Cubiertas

Este proyecto te prepara para responder:

- ¿Qué son los métodos virtuales y para qué sirven?
- ¿Cuál es la diferencia entre herencia pública, protegida y privada?
- ¿Por qué usar smart pointers en lugar de punteros raw?
- ¿Qué ventajas ofrece la STL sobre arrays C?
- ¿Cómo funciona la gestión de memoria con RAII?
- ¿Qué es const correctness y por qué importa?
- ¿Cómo se implementa serialización en C++?

## 🚀 Próximos Pasos

1. **Analiza el código**: Lee cada archivo y entiende su propósito
2. **Experimenta**: Modifica valores, agrega funciones, rompe cosas
3. **Debuggea**: Usa gdb para depurar el programa
4. **Extiende**: Implementa los ejercicios propuestos
5. **Investiga**: Busca conceptos que no entiendas

## 📖 Recursos Adicionales

- [cppreference.com](https://en.cppreference.com/) - Referencia completa de C++
- [C++ Core Guidelines](https://isocpp.github.io/CppCoreGuidelines/) - Mejores prácticas
- [LearnCpp.com](https://www.learncpp.com/) - Tutorial completo

## 🎓 Nivel de Dificultad

- **Principiante**: ⭐⭐⭐☆☆
- **Conceptos**: Intermedio-Avanzado
- **Código**: Producción-ready style

---

**¡Buena suerte con tu entrenamiento en C++!** 🚀

> Este proyecto está diseñado para simular código real de empresa. Estudia, modifica y experimenta. La mejor forma de aprender es haciendo.