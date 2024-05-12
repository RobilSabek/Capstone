from flask import Flask, request, jsonify
import pandas as pd
import joblib

app = Flask(__name__)

def preprocess_data(data):
    # Count technical and soft skills
    data['technical_skill_count'] = data['technical_skills'].apply(lambda x: len(str(x).split(', ')) if isinstance(x, str) else 0)
    data['soft_skill_count'] = data['soft_skills'].apply(lambda x: len(str(x).split(', ')) if isinstance(x, str) else 0)
    # Drop original skill columns
    data_processed = data.drop(['technical_skills', 'soft_skills'], axis=1)
    # Convert categorical variables into dummy/indicator variables
    data_processed = pd.get_dummies(data_processed, drop_first=False)
    return data_processed


# Load the SVM model and columns
model_with_columns = joblib.load('svm_model_with_columns.joblib')
model = model_with_columns['model']
X_train_columns = model_with_columns['X_train_columns']

#Prepare and predict new sample
def predict_new_sample_proba(model, sample):
    sample_df = pd.DataFrame([sample])
    sample_df = preprocess_data(sample_df)
    # Add missing columns with 0s based on training set
    for col in X_train_columns:
        if col not in sample_df.columns:
            sample_df[col] = 0
    sample_df = sample_df[X_train_columns]
    proba = model.predict_proba(sample_df)[0][1]
    return f"{proba * 100:.2f}% chance of being Accepted"


@app.route('/predict', methods=['POST'])
def predict():
    input_data = request.get_json()
    print(input_data)
    prediction = predict_new_sample_proba(model, input_data)
    return jsonify({'prediction': prediction})

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)
