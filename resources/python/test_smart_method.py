import pyDecision.algorithm.smart as smart_module
import numpy as np

matrix = np.array([
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
])
weights = np.array([0.3, 0.5, 0.2])
types = np.array([1, 1, -1])
upper = np.array([t == 1 for t in types], dtype=int)
lower = np.array([not u for u in upper], dtype=int)

result = smart_module.smart_method(matrix, weights, lower, upper, types)
print(result)
