<?php

namespace OlajosCs\QueryBuilder\Common\Statements;

use OlajosCs\QueryBuilder\Common\Statements\Common\WhereStatement;
use OlajosCs\QueryBuilder\Contracts\Statements\DeleteStatement as DeleteStatementInterface;


/**
 * Class DeleteStatement
 */
abstract class DeleteStatement extends WhereStatement implements DeleteStatementInterface
{
	/**
	 * @inheritDoc
	 */
	public function from($table)
	{
		$this->table = $table;

        return $this;
	}
}