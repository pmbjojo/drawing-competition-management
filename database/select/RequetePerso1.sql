WITH best_region AS (SELECT 
  CLUB.region,
  CONCOURS.numConcours,
  AVG(EVALUATION.note) as moyenne,
  ROW_NUMBER() OVER (PARTITION BY CONCOURS.numConcours ORDER BY AVG(EVALUATION.note) DESC) as rank
FROM 
  DESSIN, EVALUATION, COMPETITEUR, CLUB, PARTICIPE_COMPETITEUR, CONCOURS, UTILISATEUR 
WHERE DESSIN.numDessin = EVALUATION.numDessin
  AND DESSIN.numCompetiteur = COMPETITEUR.numCompetiteur
  AND COMPETITEUR.numCompetiteur=UTILISATEUR.numUtilisateur
  AND UTILISATEUR.numClub = CLUB.numClub
  AND DESSIN.numCompetiteur = PARTICIPE_COMPETITEUR.numCompetiteur
  AND PARTICIPE_COMPETITEUR.numConcours = CONCOURS.numConcours
GROUP BY 
  CLUB.region,
  CONCOURS.numConcours)
SELECT region, numConcours, moyenne
FROM best_region
WHERE rank = 1;