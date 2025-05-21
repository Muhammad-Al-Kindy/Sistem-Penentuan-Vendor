import sys, json, numpy as np
from pyDecision.algorithm.smart import smart_method

with open(sys.argv[1], 'r') as f:
    data = json.load(f)

matrix = np.array(data['matrix'])
weights = np.array(data['weights'])
types = np.array(data['types'])
upper = np.array([t == 1 for t in types], dtype=int)
lower = np.array([not u for u in upper], dtype=int)

scores = smart_method(matrix, weights, lower, upper, types)
print(json.dumps({"scores": scores.tolist()}))
