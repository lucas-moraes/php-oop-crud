<?php

require_once("../includes/init.php");


class GetMov
{

    protected $mysqli;

    public function __construct()
    {
        $this->conexao();
    }

    private function conexao()
    {
        $this->mysqli = new mysqli(BD_SERVIDOR, BD_USUARIO, BD_SENHA, BD_BANCO);
    }

    public function getMov()
    {
        $mes_hoje = date('m');
        $ano_hoje = date('Y');

        $result = $this->mysqli->query("SELECT * FROM lc_movimento WHERE mes='$mes_hoje' && ano='$ano_hoje' ORDER BY dia DESC");

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $cat = $row['categoria'];
            $res = $this->mysqli->query("SELECT nome FROM categoria WHERE id='$cat'");
            $row2 = mysqli_fetch_array($res);
            $categoria = $row2['nome'];

            if ($categoria === NULL) {
                switch ($cat) {
                    case '777':
                        $categoria = "Poupança";
                        break;
                }
            }
            $data['movimentacao'][] = array('id' => $row['id'], 'dia' => $row['dia'], 'mes' => $row['mes'], 'ano' => $row['ano'], 'tipo' => $row['tipo'], 'categoria' => $categoria, 'descricao' => $row['descricao'], 'valor' => $row['valor']);
        }

        $entrada = $this->mysqli->query("SELECT SUM(valor) as entrada FROM lc_movimento WHERE tipo='entrada' && mes='$mes_hoje' && ano='$ano_hoje'");
        $saida = $this->mysqli->query("SELECT SUM(valor*-1) as saida FROM lc_movimento WHERE tipo='saida' && mes='$mes_hoje' && ano='$ano_hoje'");
        $in = $entrada->fetch_array(MYSQLI_ASSOC);
        $out = $saida->fetch_array(MYSQLI_ASSOC);
        $resultado = ($in['entrada'] - $out['saida']);

        $data['total'] = $resultado;

        return $data;
    }
}
