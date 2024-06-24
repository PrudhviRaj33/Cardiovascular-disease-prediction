from flask import Flask
import joblib
from flask import request
from flask_cors import CORS
from flask import jsonify
import warnings
from sklearn.exceptions import InconsistentVersionWarning

warnings.filterwarnings("ignore", category=InconsistentVersionWarning)

app = Flask(__name__)
CORS(app)

model = joblib.load('best_model_pelican.pkl')

@app.route('/')
def hello():
    return 'Hello, World!'

@app.route("/predict", methods=['POST'])
def predict():
    # Get data from request
    data = request.get_json()
    print(data)
    
    map=(float(data['ap_lo']) + (float(data['ap_hi']) -float(data['ap_lo'])) / 3)
    # Use the data for prediction
    X = [[float(data['age']), float(data['gender']), float(data['height']), float(data['weight']), float(data['ap_hi']), 
          float(data['ap_lo']), float(data['cholestrol']), float(data['gluc']), float(data['smoke']), float(data['alco']), 
          float(data['active']), float(data['bmi']), float(data['bmi_category']), float(data['pulse_pressure']), map]]
    y_pred = model.predict(X)
    print(y_pred)
    # Return the prediction result
    if y_pred[0] == 0:
        return jsonify({"message": "Predicted class: No Cardiovascular disease"})
    else:
        return jsonify({"message": "Predicted class: Cardiovascular disease"})

if __name__ == '__main__':
    app.run(debug=True)