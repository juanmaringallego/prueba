# Makefile para Sistema de Gestión de Empleados
# Demuestra: compilación modular, flags de optimización, gestión de dependencias

CXX = g++
CXXFLAGS = -std=c++17 -Wall -Wextra -Wpedantic -Iinclude
DEBUGFLAGS = -g -O0
RELEASEFLAGS = -O2

SRC_DIR = src
OBJ_DIR = obj
BIN_DIR = bin
INCLUDE_DIR = include

# Archivos fuente
SOURCES = $(wildcard $(SRC_DIR)/*.cpp)
OBJECTS = $(SOURCES:$(SRC_DIR)/%.cpp=$(OBJ_DIR)/%.o)
TARGET = $(BIN_DIR)/employee_system

# Colores para output
RED = \033[0;31m
GREEN = \033[0;32m
YELLOW = \033[1;33m
NC = \033[0m # No Color

.PHONY: all clean debug release run help

# Target por defecto
all: release

# Crear directorios necesarios
$(OBJ_DIR):
	@mkdir -p $(OBJ_DIR)
	@echo "$(GREEN)✓ Directorio obj/ creado$(NC)"

$(BIN_DIR):
	@mkdir -p $(BIN_DIR)
	@echo "$(GREEN)✓ Directorio bin/ creado$(NC)"

# Compilación de objetos
$(OBJ_DIR)/%.o: $(SRC_DIR)/%.cpp | $(OBJ_DIR)
	@echo "$(YELLOW)Compilando $<...$(NC)"
	@$(CXX) $(CXXFLAGS) $(RELEASEFLAGS) -c $< -o $@

# Enlazado del ejecutable
$(TARGET): $(OBJECTS) | $(BIN_DIR)
	@echo "$(YELLOW)Enlazando ejecutable...$(NC)"
	@$(CXX) $(CXXFLAGS) $(OBJECTS) -o $(TARGET)
	@echo "$(GREEN)✓ Compilación exitosa: $(TARGET)$(NC)"

# Build en modo release (optimizado)
release: CXXFLAGS += $(RELEASEFLAGS)
release: $(TARGET)
	@echo "$(GREEN)✓ Build RELEASE completado$(NC)"

# Build en modo debug (con símbolos de depuración)
debug: CXXFLAGS += $(DEBUGFLAGS)
debug: clean $(TARGET)
	@echo "$(GREEN)✓ Build DEBUG completado$(NC)"

# Ejecutar el programa
run: $(TARGET)
	@echo "$(GREEN)Ejecutando programa...$(NC)"
	@./$(TARGET)

# Limpiar archivos compilados
clean:
	@rm -rf $(OBJ_DIR) $(BIN_DIR)
	@echo "$(GREEN)✓ Limpieza completada$(NC)"

# Mostrar ayuda
help:
	@echo "$(YELLOW)═══════════════════════════════════════════════$(NC)"
	@echo "$(YELLOW)  Sistema de Gestión de Empleados - Makefile  $(NC)"
	@echo "$(YELLOW)═══════════════════════════════════════════════$(NC)"
	@echo "Targets disponibles:"
	@echo "  make          - Compilar en modo release (por defecto)"
	@echo "  make release  - Compilar optimizado para producción"
	@echo "  make debug    - Compilar con símbolos de depuración"
	@echo "  make run      - Compilar y ejecutar"
	@echo "  make clean    - Limpiar archivos compilados"
	@echo "  make help     - Mostrar esta ayuda"
	@echo "$(YELLOW)═══════════════════════════════════════════════$(NC)"
