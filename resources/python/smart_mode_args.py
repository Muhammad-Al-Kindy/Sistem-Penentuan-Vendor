import argparse
import json
import numpy as np

def main(matrix, weights, types, subcriteria):
    matrix = np.array(matrix)
    weights = np.array(weights)
    types = np.array(types)

    # Hapus kolom yang seluruh nilainya nol (asumsi opsional/tidak diisi)
    valid_columns = ~np.all(matrix == 0, axis=0)

    matrix = matrix[:, valid_columns]
    weights = weights[valid_columns]
    types = types[valid_columns]
    subcriteria = [s for i, s in enumerate(subcriteria) if valid_columns[i]]

    # Normalisasi
    # Normalisasi aman: hindari divide by zero
    column_sums = matrix.sum(axis=0)
    column_sums[column_sums == 0] = 1  # ubah 0 jadi 1 agar tidak error
    norm_matrix = matrix / column_sums

    # Penyesuaian untuk tipe cost (-1)
    for j, t in enumerate(types):
        if t == -1:
            norm_matrix[:, j] = 1 - norm_matrix[:, j]

    # Hitung skor akhir
    scores = norm_matrix.dot(weights)

    # Peringkat
    ranking = np.argsort(scores)[::-1] + 1
    best_index = np.argmax(scores)
    best_alternative = f"Alternatif {best_index + 1}"

    # Output
    result = {
        "scores": scores.tolist(),
        "ranking": ranking.tolist(),
        "best_alternative": best_alternative,
        "subcriteria": subcriteria
    }

    print(json.dumps(result, indent=2))


if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument('--matrix', required=True, help='Matrix JSON')
    parser.add_argument('--weights', required=True, help='Weights JSON')
    parser.add_argument('--types', required=True, help='Types JSON (1=benefit, -1=cost)')
    parser.add_argument('--subcriteria', required=False, default="[]", help='List nama subkriteria')
    args = parser.parse_args()

    matrix = json.loads(args.matrix)
    weights = json.loads(args.weights)
    types = json.loads(args.types)
    subcriteria = json.loads(args.subcriteria)

    main(matrix, weights, types, subcriteria)
