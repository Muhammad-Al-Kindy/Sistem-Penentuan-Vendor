import argparse
import json
import numpy as np
import sys

def main(matrix, weights, types, subcriteria):
    matrix = np.array(matrix, dtype=float)
    weights = np.array(weights, dtype=float)
    types = np.array(types, dtype=int)

    # # Hapus kolom yang seluruh nilainya nol
    # valid_columns = ~np.all(matrix == 0, axis=0)

    # matrix = matrix[:, valid_columns]
    # weights = weights[valid_columns]
    # types = types[valid_columns]
    # subcriteria = [s for i, s in enumerate(subcriteria) if valid_columns[i]]

    # Normalisasi
    column_sums = matrix.sum(axis=0)
    column_sums[column_sums == 0] = 1  # Hindari pembagian nol
    norm_matrix = matrix / column_sums

    # Penyesuaian tipe cost
    for j, t in enumerate(types):
        if t == -1:
            norm_matrix[:, j] = 1 - norm_matrix[:, j]

    scores = norm_matrix.dot(weights)
    ranking = np.argsort(scores)[::-1] + 1
    best_index = np.argmax(scores)

    result = {
        "scores": scores.tolist(),
        "ranking": ranking.tolist(),
        "best_alternative": f"Alternatif {best_index + 1}",
        "subcriteria": subcriteria
    }

    print(json.dumps(result, indent=2))


if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument('--json', required=True, help='JSON string with matrix, weights, types, subcriteria')
    args = parser.parse_args()

    try:
        data = json.loads(args.json)
        main(data['matrix'], data['weights'], data['types'], data.get('subcriteria', []))
    except Exception as e:
        print(f"Error parsing JSON or running SMART: {e}", file=sys.stderr)
        sys.exit(1)
