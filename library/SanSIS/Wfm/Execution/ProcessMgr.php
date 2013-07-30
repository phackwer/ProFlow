<?php 

	/**
	 * Classe de 
	 * 
	 * @author Pablo Santiago Sсnchez <phackwer@gmail.com>
	 * @version 1.0.0
	 * @package SanSIS_Wfm
	 * @subpackage Execution
	 *
	 */

	abstract class SanSIS_Wfm_Execution_ProcessMgr extends SanSIS_Wfm_Base
	{
		private $contexts	= array();
		private $processes	= array();
		
		/**
		 * Mщtodo para criaчуo de processos
		 * @param WfContextData $context - contexto que possui a estrutura do processo 
		 * @param string $process_type - id da estrutura do processo no contexto  
		 * @param string $name - nome do processo criado 
		 * @param string $description - descriчуo do processo criado
		 * @return SanSIS_Wfm_Execution_Process
		 */
		public function createProcess(SanSIS_Wfm_Engine_ContextData $context, $process_type, $name, $description, $idRequester)
		{
			//buscamos a estrutura do contexto
			$process_structure = $context->getStructure($process_type);

			//criamos o processo com base na estrutura
			$process = new SanSIS_Wfm_Execution_Process($context, $process_structure, $name, $description, $idRequester);
			$process->save();

			//processo registrado apenas como 'open' - aberto mas nуo startado
			
			//registra no array de processos gerenciados no momento pela engine
			$id = $process->getId();
			$processes[$id] = $process;
			
			//retorna o processo criado
			return $process;
		}
		
		public function loadProcess($id)
		{
			$process = new SanSIS_Wfm_Engine_Process();
			
			$process->load($id);
		}
	}

?>