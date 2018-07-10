<?php

namespace NFePHP\eSocial\Factories;

/**
 * Class eSocial EvtMonit Event S-2220 constructor
 * Read for 2.4.2 layout
 *
 * @category  library
 * @package   NFePHP\eSocial
 * @copyright NFePHP Copyright (c) 2017
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-esocial for the canonical source repository
 */

use NFePHP\Common\Certificate;
use NFePHP\eSocial\Common\Factory;
use NFePHP\eSocial\Common\FactoryId;
use NFePHP\eSocial\Common\FactoryInterface;
use stdClass;

class EvtMonit extends Factory implements FactoryInterface
{
    /**
     * @var int
     */
    public $sequencial;
    /**
     * @var string
     */
    protected $evtName = 'evtMonit';
    /**
     * @var string
     */
    protected $evtAlias = 'S-2220';

    /**
     * Constructor
     * @param string $config
     * @param stdClass $std
     * @param Certificate $certificate
     */
    public function __construct(
        $config,
        stdClass $std,
        Certificate $certificate
    ) {
        parent::__construct($config, $std, $certificate);
    }

    /**
     * Node constructor
     */
    protected function toNode()
    {
        $ideEmpregador = $this->node->getElementsByTagName('ideEmpregador')->item(0);
        //o idEvento pode variar de evento para evento
        //então cada factory individualmente terá de construir o seu
        $ideEvento = $this->dom->createElement("ideEvento");
        $this->dom->addChild(
            $ideEvento,
            "indRetif",
            $this->std->indretif,
            true
        );
        $this->dom->addChild(
            $ideEvento,
            "tpAmb",
            $this->tpAmb,
            true
        );
        $this->dom->addChild(
            $ideEvento,
            "procEmi",
            $this->procEmi,
            true
        );
        $this->dom->addChild(
            $ideEvento,
            "verProc",
            $this->verProc,
            true
        );
        $this->node->insertBefore($ideEvento, $ideEmpregador);
        $ideVinculo = $this->dom->createElement("ideVinculo");
        $this->dom->addChild(
            $ideVinculo,
            "cpfTrab",
            $this->std->idevinculo->cpftrab,
            true
        );
        $this->dom->addChild(
            $ideVinculo,
            "nisTrab",
            $this->std->idevinculo->nistrab,
            true
        );
        $this->dom->addChild(
            $ideVinculo,
            "matricula",
            $this->std->idevinculo->matricula,
            true
        );
        $this->node->appendChild($ideVinculo);
        $aso = $this->dom->createElement("aso");
        $this->dom->addChild(
            $aso,
            "dtAso",
            $this->std->aso->dtaso,
            true
        );
        $this->dom->addChild(
            $aso,
            "tpAso",
            $this->std->aso->tpaso,
            true
        );
        $this->dom->addChild(
            $aso,
            "resAso",
            $this->std->aso->resaso,
            true
        );
        if (isset($this->std->aso->exame)) {
            foreach ($this->std->aso->exame as $exa) {
                $exame = $this->dom->createElement("exame");
                $this->dom->addChild(
                    $exame,
                    "dtExm",
                    $exa->dtexm,
                    true
                );
                $this->dom->addChild(
                    $exame,
                    "procRealizado",
                    !empty($exa->procrealizado) ? $exa->procrealizado : null,
                    false
                );
                $this->dom->addChild(
                    $exame,
                    "obsProc",
                    !empty($exa->obsproc) ? $exa->obsproc : null,
                    false
                );
                $this->dom->addChild(
                    $exame,
                    "interprExm",
                    $exa->interprexm,
                    true
                );
                $this->dom->addChild(
                    $exame,
                    "ordExame",
                    $exa->ordexame,
                    true
                );
                $this->dom->addChild(
                    $exame,
                    "dtIniMonit",
                    $exa->dtinimonit,
                    true
                );
                $this->dom->addChild(
                    $exame,
                    "dtFimMonit",
                    !empty($exa->dtfimmonit) ? $exa->dtfimmonit : null,
                    false
                );
                $this->dom->addChild(
                    $exame,
                    "indResult",
                    !empty($exa->indresult) ? $exa->indresult : null,
                    false
                );
                $respMonit = $this->dom->createElement("respMonit");
                $resm = $exa->respmonit;
                $this->dom->addChild(
                    $respMonit,
                    "nisResp",
                    $resm->nisresp,
                    true
                );
                $this->dom->addChild(
                    $respMonit,
                    "nrConsClasse",
                    $resm->nrconsclasse,
                    true
                );
                $this->dom->addChild(
                    $respMonit,
                    "ufConsClasse",
                    !empty($resm->ufconsclasse) ? $resm->ufconsclasse : null,
                    false
                );
                $exame->appendChild($respMonit);
                $aso->appendChild($exame);
            }
        }
        $ideServSaude = $this->dom->createElement("ideServSaude");
        $sers = $this->std->aso->ideservsaude;
        $this->dom->addChild(
            $ideServSaude,
            "codCNES",
            !empty($sers->codcnes) ? $sers->codcnes : null,
            false
        );
        $this->dom->addChild(
            $ideServSaude,
            "frmCtt",
            $sers->frmctt,
            true
        );
        $this->dom->addChild(
            $ideServSaude,
            "email",
            !empty($sers->email) ? $sers->email : null,
            false
        );
        $medico = $this->dom->createElement("medico");
        $med = $sers->medico;
        $this->dom->addChild(
            $medico,
            "nmMed",
            $med->nmmed,
            true
        );
        $crm = $this->dom->createElement("crm");
        $this->dom->addChild(
            $crm,
            "nrCRM",
            $med->nrcrm,
            true
        );
        $this->dom->addChild(
            $crm,
            "ufCRM",
            $med->ufcrm,
            true
        );
        $medico->appendChild($crm);
        $ideServSaude->appendChild($medico);
        $aso->appendChild($ideServSaude);
        $this->node->appendChild($aso);
        //finalização do xml
        $this->eSocial->appendChild($this->node);
        //$this->xml = $this->dom->saveXML($this->eSocial);
        $this->sign();
    }
}
