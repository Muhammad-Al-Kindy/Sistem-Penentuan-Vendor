import argparse
import json
import numpy as np
from pyDecision.algorithm.smart import smart_method

def process(data):
    matrix = np.array(data["matrix"])
    weights = np.array(data["weights"])
    types = np.array(data["types"])

    upper = np.array([t == 1 for t in types], dtype=int)
    lower = np.array([not u for u in upper], dtype=int)

    scores = smart_method(matrix, weights, lower, upper, types)
    print(json.dumps({"scores": scores.tolist()}, indent=2))

if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument('--jsondata', required=True, help='JSON string with SMART input')
    args = parser.parse_args()

    data = json.loads(args.jsondata)
    process(data)
