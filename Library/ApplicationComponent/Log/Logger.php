<?php
/**
 * Created by Aurelien
 * Date: 03/07/13
 * Time: 22:42
 */

namespace Library\ApplicationComponent\Log;

use Library\Application;
use Library\ApplicationComponent\ApplicationComponent;

class Logger extends ApplicationComponent{

    private $folder;

    // Période (pour l'archivage des logs)
    const PERIOD_VOID   = 'VOID';    // Aucun archivage
    const PERIOD_DAY    = 'DAY';     // Archivage journalier
    const PERIOD_MONTH  = 'MONTH';   // Archivage mensuel
    const PERIOD_YEAR   = 'YEAR';    // Archivage annuel

    // Niveau d'importance
    const LEVEL_TRACE   = 'Trace';   // Entrée et sortie de méthodes
    const LEVEL_DEBUG   = 'Debug';   // Affichage de valeur de données
    const LEVEL_INFO    = 'Info';    // Chargement d'un fichier, début et fin d'exécution d'un traitement long
    const LEVEL_WARN    = 'Warn';    // Erreur de login, données invalides
    const LEVEL_ERROR   = 'Error';   // Toutes les exceptions capturées qui n'empêchent pas l'application de fonctionner
    const LEVEL_FATAL   = 'Fatal';   // Indisponibilité d'une base de données, toutes les exceptions qui empêchent l'application de fonctionner
    const LEVEL_GENERAL = 'General'; // Non classé
    
    /**
     * Constructeur
     * Vérifie que le dossier éxiste (default: ./Applications/{AppName}/Logs/)
     *
     * @param Application $app Instance de l'application
     * @throws \Exception Levée si le dossier n'existe pas
     */
    public function __construct(Application $app){
        parent::__construct($app);

        $path = SERVER_ROOT.'Applications'.DIRECTORY_SEPARATOR.$this->app()->name().DIRECTORY_SEPARATOR.'Logs'.DIRECTORY_SEPARATOR;
        if(!is_dir($path)){
            mkdir($path);
        }
        $this->folder = realpath($path);
    }
    
    /**
     * Retourne le chemin vers un fichier de log déterminé à partir des paramètres $level, $name et $period.
	 * (ex: /Applications/{AppName}/Logs/Error/2013/2013_erreur.log)
     * Elle créé le chemin si il n'éxiste pas.
	 *
	 * @param string $level Dossier dans lequel sera enregistré le fichier de log
     * @param string $name Nom du fichier de log
     * @param string $period Période : PERIOD_VOID, PERIOD_DAY, PERIOD_MONTH ou PERIOD_YEAR
	 * @return string Chemin vers le fichier de log
    **/
    protected function path($level, $name, $period = self::PERIOD_VOID){
        # Création dossier du level (./Applications/{AppName}/Logs/{Level}/)
        switch($level){
            case self::LEVEL_GENERAL:
                $path = $this->folder.'/';
                break;
            case self::LEVEL_TRACE:
            case self::LEVEL_DEBUG:
            case self::LEVEL_INFO:
            case self::LEVEL_WARN:
            case self::LEVEL_ERROR:
            case self::LEVEL_FATAL:
                $path = $this->folder.'/'.$level.'/';
                if(!is_dir($path)){
                    mkdir($path);
                }
                break;
            default:
                throw new \Exception('Level non pris en charge');
                break;
        }

        # Création du dossier de la période (./Applications/{AppName}/Logs/{Level}/{Period}/)
        switch($period){
            case self::PERIOD_DAY:
                $current_day = date('Ymd');
                $path = $path.$current_day;
                if( !is_dir($path) ){
                    mkdir($path);
                }
                $logfile = $path.'/'.$current_day.'_'.$name.'.log';
                break;
            case self::PERIOD_MONTH:
                $mois_courant = date('Ym');
                $path = $path.$mois_courant;
                if( !is_dir($path) ){
                    mkdir($path);
                }
                $logfile = $path.'/'.$mois_courant.'_'.$name.'.log';
                break;
            case self::PERIOD_YEAR:
                $current_year = date('Y');
                $path = $path.$current_year;
                if( !is_dir($path) ){
                    mkdir($path);
                }
                $logfile = $path.'/'.$current_year.'_'.$name.'.log';
                break;
            case self::PERIOD_VOID:
                $logfile = $path.$name.'.log';
                break;
            default:
                throw new \Exception('Periode non prise en charge');
                break;
        }
        
        return $logfile;
    }
    
    /**
	 * Enregistre $row dans le fichier log déterminé à partir des paramètres $level, $name et $period
     *
     * @param string $level Dossier dans lequel sera enregistré le fichier de log
     * @param string $name Nom du fichier de log
     * @param string $row Texte à ajouter au fichier de log
     * @param string $period Période : PERIOD_VOID, PERIOD_DAY, PERIOD_MONTH ou PERIOD_YEAR
    **/
    protected function log($level, $name, $row, $period){
        # Contrôle des arguments
        if(empty($name) || empty($row))throw new \Exception("Paramètre manquant");

        $logfile = $this->path($level, $name, $period);

		# Ajout de la date, de l'heure, du level en début de ligne et du retour chariot en fin de ligne
        $row = date('d/m/Y H:i:s').' ['.$level.'] '.$row."\n";

        $this->write($logfile, $row);
    }
    
    /**
     * Écrit (append) $row dans $logfile
     *
     * @param string $logfile Chemin vers le fichier de log
     * @param string $row Chaîne de caractères à ajouter au fichier
    **/
    protected function write($logfile, $row){
        $file = fopen($logfile,'a+');
        fputs($file, $row);
        fclose($file);
    }

    /**
     * Enregistre $row dans le fichier log Trace déterminé à partir des paramètres $name et $period
     *
     * @param string $name Nom du fichier de log
     * @param string $row Texte à ajouter au fichier de log
     * @param string $period Période : PERIOD_VOID, PERIOD_DAY, PERIOD_MONTH ou PERIOD_YEAR
     **/
    public function trace($name, $row, $period = self::PERIOD_VOID){
        $this->log(self::LEVEL_TRACE, $name, $row, $period);
    }

    /**
     * Enregistre $row dans le fichier log Debug déterminé à partir des paramètres $name et $period
     *
     * @param string $name Nom du fichier de log
     * @param string $row Texte à ajouter au fichier de log
     * @param string $period Période : PERIOD_VOID, PERIOD_DAY, PERIOD_MONTH ou PERIOD_YEAR
     **/
    public function debug($name, $row, $period = self::PERIOD_VOID){
        $this->log(self::LEVEL_DEBUG, $name, $row, $period);
    }

    /**
     * Enregistre $row dans le fichier log Info déterminé à partir des paramètres $name et $period
     *
     * @param string $name Nom du fichier de log
     * @param string $row Texte à ajouter au fichier de log
     * @param string $period Période : PERIOD_VOID, PERIOD_DAY, PERIOD_MONTH ou PERIOD_YEAR
     **/
    public function info($name, $row, $period = self::PERIOD_VOID){
        $this->log(self::LEVEL_INFO, $name, $row, $period);
    }

    /**
     * Enregistre $row dans le fichier log Warn déterminé à partir des paramètres $name et $period
     *
     * @param string $name Nom du fichier de log
     * @param string $row Texte à ajouter au fichier de log
     * @param string $period Période : PERIOD_VOID, PERIOD_DAY, PERIOD_MONTH ou PERIOD_YEAR
     **/
    public function warn($name, $row, $period = self::PERIOD_VOID){
        $this->log(self::LEVEL_WARN, $name, $row, $period);
    }

    /**
     * Enregistre $row dans le fichier log Error déterminé à partir des paramètres $name et $period
     *
     * @param string $name Nom du fichier de log
     * @param string $row Texte à ajouter au fichier de log
     * @param string $period Période : PERIOD_VOID, PERIOD_DAY, PERIOD_MONTH ou PERIOD_YEAR
     **/
    public function error($name, $row, $period = self::PERIOD_VOID){
        $this->log(self::LEVEL_ERROR, $name, $row, $period);
    }

    /**
     * Enregistre $row dans le fichier log Fatal déterminé à partir des paramètres $name et $period
     *
     * @param string $name Nom du fichier de log
     * @param string $row Texte à ajouter au fichier de log
     * @param string $period Période : PERIOD_VOID, PERIOD_DAY, PERIOD_MONTH ou PERIOD_YEAR
     **/
    public function fatal($name, $row, $period = self::PERIOD_VOID){
        $this->log(self::LEVEL_FATAL, $name, $row, $period);
    }

    /**
     * Enregistre $row dans le fichier log General déterminé à partir des paramètres $name et $period
     *
     * @param string $name Nom du fichier de log
     * @param string $row Texte à ajouter au fichier de log
     * @param string $period Période : PERIOD_VOID, PERIOD_DAY, PERIOD_MONTH ou PERIOD_YEAR
     **/
    public function general($name, $row, $period = self::PERIOD_VOID){
        $this->log(self::LEVEL_GENERAL, $name, $row, $period);
    }

}
?>