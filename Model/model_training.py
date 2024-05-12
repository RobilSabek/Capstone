# import numpy as np
import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.svm import SVC
from sklearn.metrics import accuracy_score
import joblib

# Load the dataset
file_path = './Data.xlsx'
data = pd.read_excel(file_path)

# Preprocess the data
def preprocess_data(data):
    data['technical_skill_count'] = data['technical_skills'].apply(lambda x: len(str(x).split(', ')) if isinstance(x, str) else 0)
    data['soft_skill_count'] = data['soft_skills'].apply(lambda x: len(str(x).split(', ')) if isinstance(x, str) else 0)
    data_processed = data.drop(['technical_skills', 'soft_skills'], axis=1)
    data_processed = pd.get_dummies(data_processed, drop_first=False)
    return data_processed

data_processed = preprocess_data(data)

# Split data into features and target
X = data_processed.drop(['is_Accepted_No', 'is_Accepted_Yes'], axis=1)
y = data_processed['is_Accepted_Yes']

# Split the data into training and testing sets
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Initialize models
svm = SVC(probability=True)  # Enable probability for SVM

# Fit models
svm.fit(X_train, y_train)

# Predict on test set
y_pred_svm = svm.predict(X_test)

# Calculate accuracy
accuracy_svm = accuracy_score(y_test, y_pred_svm)
print("Accuracy of SVM:", accuracy_svm)

# Function to prepare and predict new sample
def predict_new_sample_proba(model, sample):
    sample_df = pd.DataFrame([sample])
    sample_df = preprocess_data(sample_df)
    # Add missing columns with 0s based on training set
    for col in X_train.columns:
        if col not in sample_df.columns:
            sample_df[col] = 0
    sample_df = sample_df[X_train.columns]
    # Get the probability of the positive class (Accepted)
    proba = model.predict_proba(sample_df)[0][1]
    return f"{proba * 100:.2f}% chance of being Accepted"


# Sample data
sample = {
    'highest_level_of_education': 'Bachelor\'s Degree',
    'nb_jobs/internships_applied': '6-10',
    'nb_interviews': '9+',
    'technical_skills': 'Programming',
    'soft_skills': 'Communication',
    'stress_level': 'Low'
}

# Predict using the Logistic Regression model
print("Prediction for sample using SVM:", predict_new_sample_proba(svm, sample))

#Assuming X_train is your final training features DataFrame
X_train_columns = X_train.columns

# print(X_train_columns)

joblib.dump({'model': svm, 'X_train_columns': X_train_columns}, 'svm_model_with_columns.joblib')
