USER="sitewebuser"
PASSWORD="sitewebpassword"
DATABASE="sitewebdb"

mysql -u $USER --password=$PASSWORD $DATABASE < create.sql
mysql -u $USER --password=$PASSWORD $DATABASE < insert/insert_club.sql
mysql -u $USER --password=$PASSWORD $DATABASE < insert/insert_utilisateur.sql
mysql -u $USER --password=$PASSWORD $DATABASE < insert/insert_president.sql
mysql -u $USER --password=$PASSWORD $DATABASE < insert/insert_concours.sql
mysql -u $USER --password=$PASSWORD $DATABASE < insert/insert_competiteur.sql
mysql -u $USER --password=$PASSWORD $DATABASE < insert/insert_administrateur.sql
mysql -u $USER --password=$PASSWORD $DATABASE < insert/insert_directeur.sql
mysql -u $USER --password=$PASSWORD $DATABASE < insert/insert_dessin.sql
mysql -u $USER --password=$PASSWORD $DATABASE < insert/insert_participe_club.sql
mysql -u $USER --password=$PASSWORD $DATABASE < insert/insert_particpe_competiteur.sql
mysql -u $USER --password=$PASSWORD $DATABASE < insert/insert_dirige.sql
mysql -u $USER --password=$PASSWORD $DATABASE < insert/insert_evaluateur.sql
mysql -u $USER --password=$PASSWORD $DATABASE < insert/insert_evaluation.sql