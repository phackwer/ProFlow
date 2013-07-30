<?php

/**
 * Modelo para regras de negócio referentes ao departamento
 *
 * @package		ProFlow
 * @subpackage	models
 * @category	Model
 * @name		Departamento
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */

class ProFlow_Model_Departamento extends ProFlow_Model_DbTable_Departamento
{
	public function getList($params = null)
	{
		if (!isset($params['status_tupla']) || $params['status_tupla'] === null)
		{
			$where = 'status_tupla = \'1\'';
			$where2 = 'e1.status_tupla = \'1\'';
		}
		else if ($params['status_tupla'])
		{
			$where = 'status_tupla = \''.$params['status_tupla'].'\'';
			$where2 = 'e1.status_tupla = \''.$params['status_tupla'].'\'';
		}
		else
			$where2 = $where = ' 1=1 ';
		
		$query = "
		WITH RECURSIVE t(id, path) AS ( 
				SELECT id, 
					ARRAY[id], 
					nome, 
					status_tupla 
				FROM
					departamento 
				WHERE 
					id_subordinado_a IS NULL and 
					".$where." 
			
			UNION ALL 
			
				SELECT 
					e1.id, 
					t.path || ARRAY[e1.id], 
					e1.nome, 
					e1.status_tupla 
				FROM 
					departamento e1 JOIN t ON (e1.id_subordinado_a = t.id) 
				WHERE 
					".$where2." 
			)
		SELECT 
			id, 
			CASE WHEN array_upper(path,1)>1 THEN '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ELSE '' END || REPEAT('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', array_upper(path,1)-2) || nome as \"nome\",
			CASE WHEN status_tupla = '1' THEN 'Ativo' ELSE 'Inativo' END as status
			FROM t ORDER BY
		
			path ASC;
		";
		
// 		$query = "WITH RECURSIVE q AS
// 		(
// 				SELECT  h, 1 AS level, ARRAY[id] AS breadcrumb
// 				FROM    departamento h
// 				WHERE   id_subordinado_a is null
// 			UNION ALL
// 				SELECT  hi, q.level + 1 AS level, breadcrumb || id
// 				FROM    q
// 				JOIN    departamento hi
// 				ON      hi.id_subordinado_a = (q.h).id
// 		)
// 		SELECT 
// 			(q.h).id,
// 			REPEAT('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', level) || (q.h).nome as nome,
// 			level,
// 			breadcrumb::VARCHAR AS path
// 		FROM    q
// 		ORDER BY
// 			nome,
// 			breadcrumb";
		
		return $this->getAdapter()->fetchAll($query);
	}
}

