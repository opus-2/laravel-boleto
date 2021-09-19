@extends('BoletoHtmlRender::layout')
@section('boleto')
	<style>
	body > div:first-child { margin: 10em auto 0; }
	.barcode { height: 60px;}
	.table-boleto .titulo { font-size:5pt; }
	.table-boleto .conteudo { font-size: 8pt;}
	.table-boleto .instrucoes { vertical-align: top; line-height: 1.6;}
	.table-boleto .instrucoes .conteudo { line-height: 1.7;}
	.table-boleto img {
		width: 26mm;
		padding: 0;
	}
	</style>
    @foreach($boletos as $i => $boleto)
        @php extract($boleto, EXTR_OVERWRITE); @endphp
        @if($mostrar_instrucoes)
            <div class="noprint info">
                <h2>Instruções de Impressão</h2>
                <ul>
                    @forelse ($instrucoes_impressao as $instrucao_impressao)
                        <li>{{ $instrucao_impressao }}</li>
                    @empty

                        <li>Imprima em impressora jato de tinta (ink jet) ou laser em qualidade normal ou alta (Não use
                            modo econômico).
                        </li>
                        <li>Utilize folha A4 (210 x 297 mm) ou Carta (216 x 279 mm) e margens mínimas à esquerda e à
                            direita do formulário.
                        </li>
                        <li>Corte na linha indicada. Não rasure, risque, fure ou dobre a região onde se encontra o
                            código de barras.
                        </li>
                        <li>Caso não apareça o código de barras no final, pressione F5 para atualizar esta tela.</li>
                        <li>Caso tenha problemas ao imprimir, copie a sequencia numérica abaixo e pague no caixa
                            eletrônico ou no internet banking:
                        </li>
                    @endforelse
                </ul>
                <span class="header">Linha Digitável: {{ $linha_digitavel }}</span>
                <span class="header">Número: {{ $numero }}</span>
                {!! $valor ? '<span class="header">Valor: R$' . $valor . '</span>' : '' !!}
                <br>
            </div>
        @endif

		<!--
        <div class="linha-pontilhada" style="margin-bottom: 20px;">Recibo do pagador</div>
        <div class="info-empresa">
            @if ($logo)
                <div style="display: inline-block;">
                    <img alt="logo" src="{{ $logo_base64 }}"/>
                </div>
            @endif
            <div style="display: inline-block; vertical-align: super;">
                <div><strong>{{ $beneficiario['nome'] }}</strong></div>
                <div>{{ $beneficiario['documento'] }}</div>
                <div>{{ $beneficiario['endereco'] }}</div>
                <div>{{ $beneficiario['endereco2'] }}</div>
            </div>
        </div>
        <br>
-->
<div style="padding-top: 4.5cm">&nbsp;</div>
<?php for ($secao = 1; $secao <= 2; $secao++) : ?>
        <table class="table-boleto<?php echo ($secao == 1 ? ' push-down' : ''); ?>" cellpadding="0" cellspacing="0" border="0">
            <tbody>
            <tr>
                <td valign="bottom" colspan="6" class="noborder nopadding">
                    <div class="logocontainer">
                        <div class="logobanco">
                            <img src="{{ isset($logo_banco_base64) && !empty($logo_banco_base64) ? $logo_banco_base64 : 'https://dummyimage.com/150x75/fff/000000.jpg&text=+' }}" alt="logo do banco">
                        </div>
                        <div class="codbanco">{{ $codigo_banco_com_dv }}</div>
                    </div>
					<?php if ($secao == 1) : ?>
					<div class="linha-digitavel">Recibo do Pagador</div>
					<?php elseif ($secao == 2): ?>
					<div class="linha-digitavel">{{ $linha_digitavel }}</div>
					<?php endif; ?>

                </td>
            </tr>
			<tr>
				<td colspan="5" class="top-2">
					<div class="titulo">Local de pagamento</div>
					<div class="conteudo" style="font-size: 7pt">{{ $local_pagamento }}</div>
				</td>
				<td width="180" class="top-2">
					<div class="titulo">Vencimento</div>
					<div class="conteudo rtl" style="font-size: 10pt; padding-bottom: 3px">{{ $data_vencimento->format('d/m/Y') }}</div>
				</td>
			</tr>
			<tr>
				<td colspan="5">
					<div class="titulo">Beneficiário</div>
					<div class="conteudo">{{ $beneficiario['nome_documento'] }}</div>
			<!--		<div class="conteudo">{{ $beneficiario['endereco'] }} - {{ $beneficiario['endereco2'] }}</div> -->
				</td>
				<td>
					<div class="titulo">Agência/Código do Beneficiário</div>
					<div class="conteudo rtl">{{ $agencia_codigo_beneficiario }}</div>
				</td>
			</tr>
			<tr>
				<td width="90">
					<div class="titulo">Data do Documento</div>
					<div class="conteudo">{{ $data_documento->format('d/m/Y') }}</div>
				</td>
				<td width="120">
					<div class="titulo">Nº do Documento</div>
					<div class="conteudo">{{ $numero_documento }}</div>
				</td>
				<td width="50">
					<div class="titulo">Espécie Doc.</div>
					<div class="conteudo">{{ $especie_doc }}</div>
				</td>
				<td>
					<div class="titulo">Aceite</div>
					<div class="conteudo">{{ $aceite }}</div>
				</td>
				<td width="110">
					<div class="titulo">Data Processamento</div>
					<div class="conteudo">{{ $data_processamento->format('d/m/Y') }}</div>
				</td>
				<td>
					<div class="titulo">Nosso Número</div>
					<div class="conteudo rtl">{{ $nosso_numero_boleto }}</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="titulo">&nbsp;</div>
					<div class="conteudo">{{ $uso_banco }}</div>
				</td>
				<td>
					<div class="titulo">Espécie</div>
					<div class="conteudo">{{ $especie == 'R$' ? 'REAL' : $especie }}</div>
				</td>
				<td colspan="2">
					<div class="titulo">Quantidade Moeda</div>
					<div class="conteudo"></div>
				</td>
				<td>
					<div class="titulo">Valor Moeda</div>
					<div class="conteudo"></div>
				</td>
				<td>
					<div class="titulo">Valor Documento</div>
					<div class="conteudo rtl" style="font-size:10pt; padding-bottom:2px">{{ $especie }} {{ $valor }}</div>
				</td>
			</tr>
			<tr>
				<td colspan="5" rowspan="5" class="instrucoes">
					<div class="titulo">Instruções</div>
					<div class="conteudo">{{ $instrucoes[0] }}</div>
					<div class="conteudo">{{ $instrucoes[1] }}</div>
					<div class="conteudo">{{ $demonstrativo[0] }}</div>
					<div class="conteudo">{{ $demonstrativo[1] }}</div>
					<div class="conteudo">{{ $demonstrativo[2] }}</div>
					<div class="conteudo">{{ $demonstrativo[3] }}</div>

				</td>
				<td>
					<div class="titulo">(-) Descontos / Abatimentos</div>
					<div class="conteudo rtl"></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="titulo">(-) Outras deduções</div>
					<div class="conteudo rtl"></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="titulo">(+) Mora / Multa</div>
					<div class="conteudo rtl"></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="titulo">(+) Outros acréscimos</div>
					<div class="conteudo rtl"></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="titulo">(=) Valor Cobrado</div>
					<div class="conteudo rtl"></div>
				</td>
			</tr>
			<tr>
				<td colspan="5">
					<div class="titulo">Pagador:</div>
					<div class="conteudo">{{ $pagador['nome_documento'] }}</div>
					<div class="conteudo">{{ $pagador['endereco'] }}</div>
					<div class="conteudo">{{ $pagador['endereco2'] }}</div>
				</td>
				<td class="noleftborder" style="vertical-align:top">

				</td>
			</tr>
			<tr>
				<td colspan="5" class="notopborder">
					<?php if ($secao == 1) : ?>
						<div class="titulo">Sacador/Avalista:
							<div class="conteudo sacador">{{ $sacador_avalista ? $sacador_avalista['nome_documento'] : '' }}</div>
						</div>
					<?php else: ?>
						<div class="titulo">Beneficiário Final::
							<div class="conteudo sacador"></div>
						</div>
					<?php endif; ?>
				</td>
				<td class="titulo notopborder noleftborder">
					<div>Código de Baixa:</div>
				</td>
			</tr>
			<tr>
				<td colspan="6" style="vertical-align:top; padding:0" class="noleftborder norightborder">
				<?php if ($secao == 1) : ?>
					<div class="titulo" style="width: 11.3cm; float:left">
						<br />
						Recebimento através do cheque Nº<br />
						Do Banco<br />
						Esta quitação só terá validade após o pagamento do cheque pelo banco pagador.<br />
						Até o vencimento, pagável em qualquer agência bancária.
					</div>
				<?php elseif ($secao == 2) : ?>
					<div style="padding-left:0; padding-top:1mm; width: 11.3cm; float:left;">{!! $codigo_barras !!}</div>
				<?php endif; ?>
				<div>
                    <div class="titulo" style="text-align:center; height: 1.3cm; width: 6cm; float:right;"><?php echo str_repeat("&#9472;",14); ?>&nbsp;Autenticação mecânica&nbsp;<?php echo str_repeat("&#9472;",14); ?></div>
                </div>
			</tr>
            </tbody>
        </table>
		<?php if ($secao == 1) {
			echo '<br /><div class="linha-pontilhada">Corte na linha abaixo</div><br />';
		} else {
			echo '<div style="position: relative; right:0; top: -4mm; font-weight:bold; text-align:right; font-size:10pt">FICHA DE COMPENSAÇÃO</div>';
		} ?>
        </td>

		<?php endfor; ?>

        @if(count($boletos) > 1 && count($boletos)-1 != $i)
            <div style="page-break-before:always"></div>
        @endif
    @endforeach
@endsection
