
import json
import numpy as np
from pyDecision.algorithm.smart import smart_method

def main():
    try:
        print("=== SMART Decision Input (Step-by-Step) ===")
        n_alternatif = int(input("Jumlah alternatif: "))
        n_kriteria = int(input("Jumlah kriteria: "))

        print("\nMasukkan nilai matrix satu per satu:")
        matrix = []
        for i in range(n_alternatif):
            row = []
            for j in range(n_kriteria):
                val = float(input(f"  Nilai untuk alternatif {i+1}, kriteria {j+1}: "))
                row.append(val)
            matrix.append(row)

        print("\nMasukkan bobot satu per satu:")
        weights = []
        for j in range(n_kriteria):
            w = float(input(f"  Bobot untuk kriteria {j+1}: "))
            weights.append(w)

        print("\nMasukkan tipe kriteria satu per satu (1 = benefit, -1 = cost):")
        types = []
        for j in range(n_kriteria):
            t = int(input(f"  Tipe untuk kriteria {j+1} (1/-1): "))
            types.append(t)

        # Proses
        matrix = np.array(matrix)
        weights = np.array(weights)
        types = np.array(types)

        upper = np.array([t == 1 for t in types], dtype=int)
        lower = np.array([not u for u in upper], dtype=int)

        result = smart_method(matrix, weights, lower, upper, types)

        print("\n=== Hasil Perhitungan SMART ===")
        print(json.dumps({"scores": result.tolist()}, indent=2))

    except Exception as e:
        print(f"❌ Terjadi kesalahan: {e}")

if __name__ == "__main__":
    main()
