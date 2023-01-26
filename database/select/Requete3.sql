SELECT 
  DESSIN.numDessin,
  YEAR(EVALUATION.dateEvaluation),
  CONCOURS.descriptif,
  comp.nom,
  comp.prenom,
  eva.nom,
  eva.prenom,
  DESSIN.commentaire,
  EVALUATION.note,
  EVALUATION.commentaire
FROM DESSIN, UTILISATEUR eva, UTILISATEUR comp, EVALUATION, COMPETITEUR, EVALUATEUR, PARTICIPE_COMPETITEUR, CONCOURS
WHERE DESSIN.numDessin = EVALUATION.numDessin
  AND DESSIN.numCompetiteur = COMPETITEUR.numCompetiteur
  AND EVALUATION.numEvaluateur = EVALUATEUR.numEvaluateur
  AND DESSIN.numCompetiteur = PARTICIPE_COMPETITEUR.numCompetiteur
  AND PARTICIPE_COMPETITEUR.numConcours = CONCOURS.numConcours
  AND EVALUATEUR.numEvaluateur=eva.numUtilisateur
  AND COMPETITEUR.numCompetiteur=comp.numUtilisateur
ORDER BY DESSIN.numDessin ASC;