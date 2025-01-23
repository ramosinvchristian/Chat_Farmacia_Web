from flask import Flask, render_template, request
import speech_recognition as sr

app = Flask(__name__)

# Diccionarios con medicamentos clasificados
medicamentos = {
    "Uno": {
        "mayores": ["paracetamol 500mg", "paracetamol 1000mg"],
        "menores": ["ibuprofeno pediátrico"],
        "sin_restriccion": ["paracetamol 500mg"],
        "con_restriccion": ["paracetamol 500mg"]
    },
    "Dos": {
        "mayores": ["benzocaina", "ibuprofeno"],
        "menores": ["ibuprofeno pediátrico"],
        "sin_restriccion": ["benzocaina"],
        "con_restriccion": ["ibuprofeno"]
    },
    "Tres": {
        "mayores": ["antigripal adulto"],
        "menores": ["antigripal pediátrico"],
        "sin_restriccion": ["antigripal común"],
        "con_restriccion": ["descongestionante"]
    },
}

# Función para recomendar medicamento
def recomendar_medicamento(sintoma, edad, restricciones):
    if sintoma not in medicamentos:
        return f"No hay medicamentos registrados para {sintoma}."

    grupo_edad = "mayores" if edad >= 18 else "menores"
    grupo_restriccion = "sin_restriccion" if not restricciones else "con_restriccion"

    opciones = medicamentos[sintoma]
    recomendaciones = set(opciones.get(grupo_edad, [])) & set(opciones.get(grupo_restriccion, []))

    if recomendaciones:
        return f"Medicamentos recomendados para {sintoma}: {', '.join(recomendaciones)}"
    else:
        return f"No se encontró medicamento adecuado para {sintoma} según las condiciones dadas."

# Ruta para la página principal
@app.route("/", methods=["GET", "POST"])
def index():
    if request.method == "POST":
        sintoma = request.form.get("sintoma")
        edad = int(request.form.get("edad"))
        restricciones = request.form.get("restricciones") == "si"

        # Obtener recomendación
        resultado = recomendar_medicamento(sintoma.capitalize(), edad, restricciones)
        return render_template("resultado.html", resultado=resultado)
    return render_template("index.html")

if __name__ == "__main__":
    app.run(debug=True)
