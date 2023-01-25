SELECT numEvaluateur, COUNT(numEvaluateur)
FROM EVALUATION 
GROUP BY numEvaluateur;