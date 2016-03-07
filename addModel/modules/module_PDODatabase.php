<?PHP
class PDODatabase{
	  var $dbName;
	  var $dbAdmin;
	  var $dbPass;
	  var $dbServer;
	  
	  function __construct($dbAdmin, $dbName, $dbPass, $dbServer=localhost){
	  	
	  	$this->dbAdmin=$dbAdmin;
	  	$this->dbName=$dbName;
	  	$this->dbPass=$dbPass;
	  	$this->dbServer=$dbServer;
	  	
	  	if($this->dbServer == 'NULL'){
	  	    $this->dbServer = localhost;
	  	}
	  	
	  	    $this->dsn = "mysql:host=".$this->dbServer.";port=3306;dbname=".$this->dbName;
	  	    $this->db = new PDO($this->dsn, $this->dbAdmin, $this->dbPass);
	  	       
	  	
	  }
	  function select($sql){
	      $this->sql = $this->db->prepare($sql);
	      $this->sql->execute();
	      $i=0;
	      $result = array();
	      $n=1;
	      $row = $this->sql->fetchAll(PDO::FETCH_ASSOC);
	      
	      foreach($row as $val){
	          $result[$i] = $val;
	          $i++;
	      }
	      $count = count($result);
	      return $result;
	  }
	  
	  function insert($sql){
	  	try{
	  	$this->sql = $this->db->prepare($sql);
	  	$this->sql->execute();
	  	}

catch (PDOException $e)

{

return $e->getMessage();

}
	  
	  } 
          function update($sql){
              $this->sql = $this->db->prepare($sql);
              $this->sql->execute();
          }

}

?>