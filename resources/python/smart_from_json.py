import sys
import json
import pyDecision.algorithm.smart as smart_module

def main():
    if len(sys.argv) != 2:
        print("Usage: python smart_from_json_file.py <path_to_json_file>")
        return

    try:
        with open(sys.argv[1], 'r') as f:
            data = json.load(f)

        matrix = data['matrix']
        weights = data['weights']
        types = data['types']

        # Assuming 'upper' is a list of booleans indicating if criterion is benefit (True) or cost (False)
        # We can derive 'upper' from 'types': 1 means benefit (True), -1 means cost (False)
        upper = [t == 1 for t in types]
        lower = [not u for u in upper]

        result = smart_module.smart_method(matrix, weights, lower, upper, types)

        print(json.dumps({
            "scores": result
        }, indent=2))
    except FileNotFoundError:
        print(f"File not found: {sys.argv[1]}")
    except json.JSONDecodeError:
        print("Invalid JSON file content.")
    except KeyError as e:
        print(f"Missing key in JSON input: {e}")
    except Exception as e:
        print(f"Error during processing: {e}")

if __name__ == "__main__":
    main()
