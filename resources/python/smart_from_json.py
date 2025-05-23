import argparse
import json
import numpy as np

def process(data):
    matrix = np.array(data["matrix"])
    weights = np.array(data["weights"])

    # Normalisasi matrix (divisi per kolom)
    norm_matrix = matrix / matrix.sum(axis=0)

    # Hitung skor akhir
    scores = norm_matrix.dot(weights)

    # Tampilkan hasil
    print(json.dumps({"scores": scores.tolist()}, indent=2))

if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument('--jsondata', required=True, help='JSON string with SMART input')
    args = parser.parse_args()

    data = json.loads(args.jsondata)
    process(data)
