from pyDecision.algorithm import smart
import json
import sys

def main():
    if len(sys.argv) != 2:
        print("Usage: python3 smart_decision.py <path_to_json_file>")
        return

    input_file = sys.argv[1]

    with open(input_file, 'r') as f:
        data = json.load(f)

    matrix = data['matrix']
    weights = data['weights']
    types = data['types']

    scores = smart(matrix, weights, types)

    print(json.dumps({
        "scores": scores
    }))

if __name__ == "__main__":
    main()
