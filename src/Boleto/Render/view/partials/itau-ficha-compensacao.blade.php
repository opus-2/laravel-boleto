<table class="table-boleto" cellpadding="0" cellspacing="0" border="0">
    <tbody>
    <tr>
        <td valign="bottom" colspan="8" class="noborder nopadding">
            <div class="logocontainer">
                <div class="logobanco">
                    <img style="width: 35mm; padding: .7mm;"  src="{{ isset($logo_banco_base64) && !empty($logo_banco_base64) ? $logo_banco_base64 : 'https://dummyimage.com/150x75/fff/000000.jpg&text=+' }}" alt="logo do banco">
                </div>
                <div class="codbanco">{{ $codigo_banco_com_dv }}</div>
            </div>
            <div class="linha-digitavel">{{ $linha_digitavel }}</div>
        </td>
    </tr>
    <tr>
        <td colspan="7" class="top-2">
            <div class="titulo">Local de pagamento</div>
            <div class="conteudo">Pague pelo aplicativo, internet, em agências ou correspondentes</div>
        </td>
        <td width="180" class="top-2">
            <div class="titulo">Data de vencimento</div>
            <div class="conteudo rtl" style="font-size:10pt; padding-bottom:2px">{{ $data_vencimento->format('d/m/Y') }}</div>
        </td>
    </tr>
    <tr>
        <td colspan="7">
            <div class="titulo">Nome do Beneficiário / CNPJ / CPF / Endereço</div>
            <div class="conteudo">{{ $beneficiario['nome_documento'] }}</div>
            <div class="conteudo">{{ $beneficiario['endereco'] }} - {{ $beneficiario['endereco2'] }}</div>
        </td>
        <td style="vertical-align:top">
            <div class="titulo">Agência/Código beneficiário</div>
            <div class="conteudo rtl"><br>{{ $agencia_codigo_beneficiario }}</div>
        </td>
    </tr>
    <tr>
        <td width="110" colspan="2">
            <div class="titulo">Data do documento</div>
            <div class="conteudo">{{ $data_documento->format('d/m/Y') }}</div>
        </td>
        <td width="120" colspan="2">
            <div class="titulo">Nº documento</div>
            <div class="conteudo">{{ $numero_documento }}</div>
        </td>
        <td width="60">
            <div class="titulo">Espécie doc.</div>
            <div class="conteudo">{{ $especie_doc }}</div>
        </td>
        <td>
            <div class="titulo">Aceite</div>
            <div class="conteudo">{{ $aceite }}</div>
        </td>
        <td width="110">
            <div class="titulo">Data processamento</div>
            <div class="conteudo">{{ $data_processamento->format('d/m/Y') }}</div>
        </td>
        <td>
            <div class="titulo">Nosso número</div>
            <div class="conteudo rtl">{{ $nosso_numero_boleto }}</div>
        </td>
    </tr>
    <tr>
        @if(!isset($esconde_uso_banco) || !$esconde_uso_banco)
            <td {{ !isset($mostra_cip) || !$mostra_cip ? 'colspan=2' : ''}}>
                <div class="titulo">Uso do banco</div>
                <div class="conteudo">{{ $uso_banco }}</div>
            </td>
            @endif
            @if (isset($mostra_cip) && $mostra_cip)
                    <!-- Campo exclusivo do Bradesco -->
            <td width="20">
                <div class="titulo">CIP</div>
                <div class="conteudo">{{ $cip }}</div>
            </td>
        @endif

        <td {{isset($esconde_uso_banco) && $esconde_uso_banco ? 'colspan=3': '' }}>
            <div class="titulo">Carteira</div>
            <div class="conteudo">{{ $carteira }}</div>
        </td>
        <td width="35">
            <div class="titulo">Espécie</div>
            <div class="conteudo">{{ $especie }}</div>
        </td>
        <td colspan="2">
            <div class="titulo">Quantidade</div>
            <div class="conteudo"></div>
        </td>
        <td width="110">
            <div class="titulo">Valor</div>
            <div class="conteudo"></div>
        </td>
        <td>
            <div class="titulo">(=) Valor do Documento</div>
            <div class="conteudo rtl" style="font-size:10pt; padding-bottom:2px">{{ $valor }}</div>
        </td>
    </tr>
    <tr>
        <td colspan="7" rowspan="3">
            <div class="titulo">Instruções de responsabilidade do beneficiário. Qualquer dúvida sobre este boleto, contate o beneficiário</div>
			<div class="conteudo">{{ $instrucoes[0] }}</div>
            <div class="conteudo">{{ $instrucoes[1] }}</div>
            <div class="conteudo" style="font-weight:normal">{{ $demonstrativo[0] }}</div>
            <div class="conteudo" style="font-weight:normal">{{ $demonstrativo[1] }}</div>
            <div class="conteudo" style="font-weight:normal">{{ $demonstrativo[2] }}</div>
        </td>
        <td>
            <div class="titulo">(-) Descontos / Abatimento</div>
            <div class="conteudo rtl"></div>
        </td>
    <tr>
        <td>
            <div class="titulo">(+) Juros / Multa</div>
            <div class="conteudo rtl"></div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="titulo">(=) Valor cobrado</div>
            <div class="conteudo rtl"></div>
        </td>
    </tr>
    <tr>
        <td colspan="8">
            <div class="conteudo" style="font-weight: normal; font-size: 8pt"><strong>Nome do pagador:</strong> {{ $pagador['nome_documento'] }}</div>
            <div class="conteudo" style="font-weight: normal"><strong>Endereço:</strong> {{ $pagador['endereco'] }} - {{ $pagador['endereco2'] }}</div>
			<div class="conteudo" style="font-weight: normal"><strong>Sacador/avalista:</strong> {{ $sacador_avalista ? $sacador_avalista['nome_documento'] : '' }}</div>
		</td>
    </tr>

	<tr>
        <td colspan="8" class="norightborder noleftborder top-2" style="padding-left:0; padding-top:3px">
			<div style="float:left">{!! $codigo_barras !!}</div>
			<div class="conteudo" style="font-weight:normal; float:right ">Autenticação mecânica - <strong>Ficha de compensação</strong></div>
        </td>
    </tr>

    </tbody>
</table>