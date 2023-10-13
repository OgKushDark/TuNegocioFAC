<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* notacr2.1.xml.twig */
class __TwigTemplate_22b847dd545ef074e4f3eb7e148c920dfb6c0de1b5b9ad31150e9787be1828d0 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        ob_start(function () { return ''; });
        // line 2
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<CreditNote xmlns=\"urn:oasis:names:specification:ubl:schema:xsd:CreditNote-2\" xmlns:cac=\"urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2\" xmlns:cbc=\"urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2\" xmlns:ds=\"http://www.w3.org/2000/09/xmldsig#\" xmlns:ext=\"urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2\">
    <ext:UBLExtensions>
        <ext:UBLExtension>
            <ext:ExtensionContent/>
        </ext:UBLExtension>
    </ext:UBLExtensions>
    <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
    <cbc:CustomizationID>2.0</cbc:CustomizationID>
    <cbc:ID>";
        // line 11
        echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "serie", [], "any", false, false, false, 11);
        echo "-";
        echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "correlativo", [], "any", false, false, false, 11);
        echo "</cbc:ID>
    <cbc:IssueDate>";
        // line 12
        echo twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "fechaEmision", [], "any", false, false, false, 12), "Y-m-d");
        echo "</cbc:IssueDate>
    <cbc:IssueTime>";
        // line 13
        echo twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "fechaEmision", [], "any", false, false, false, 13), "H:i:s");
        echo "</cbc:IssueTime>
    ";
        // line 14
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "legends", [], "any", false, false, false, 14));
        foreach ($context['_seq'] as $context["_key"] => $context["leg"]) {
            // line 15
            echo "    <cbc:Note languageLocaleID=\"";
            echo twig_get_attribute($this->env, $this->source, $context["leg"], "code", [], "any", false, false, false, 15);
            echo "\"><![CDATA[";
            echo twig_get_attribute($this->env, $this->source, $context["leg"], "value", [], "any", false, false, false, 15);
            echo "]]></cbc:Note>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['leg'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 17
        echo "    <cbc:DocumentCurrencyCode>";
        echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 17);
        echo "</cbc:DocumentCurrencyCode>
    <cac:DiscrepancyResponse>
        <cbc:ReferenceID>";
        // line 19
        echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "numDocfectado", [], "any", false, false, false, 19);
        echo "</cbc:ReferenceID>
        <cbc:ResponseCode>";
        // line 20
        echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "codMotivo", [], "any", false, false, false, 20);
        echo "</cbc:ResponseCode>
        <cbc:Description>";
        // line 21
        echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "desMotivo", [], "any", false, false, false, 21);
        echo "</cbc:Description>
    </cac:DiscrepancyResponse>
    ";
        // line 23
        if (twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "compra", [], "any", false, false, false, 23)) {
            // line 24
            echo "    <cac:OrderReference>
        <cbc:ID>";
            // line 25
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "compra", [], "any", false, false, false, 25);
            echo "</cbc:ID>
    </cac:OrderReference>
    ";
        }
        // line 28
        echo "    <cac:BillingReference>
        <cac:InvoiceDocumentReference>
            <cbc:ID>";
        // line 30
        echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "numDocfectado", [], "any", false, false, false, 30);
        echo "</cbc:ID>
            <cbc:DocumentTypeCode>";
        // line 31
        echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipDocAfectado", [], "any", false, false, false, 31);
        echo "</cbc:DocumentTypeCode>
        </cac:InvoiceDocumentReference>
    </cac:BillingReference>
    ";
        // line 34
        if (twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "guias", [], "any", false, false, false, 34)) {
            // line 35
            echo "    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "guias", [], "any", false, false, false, 35));
            foreach ($context['_seq'] as $context["_key"] => $context["guia"]) {
                // line 36
                echo "    <cac:DespatchDocumentReference>
        <cbc:ID>";
                // line 37
                echo twig_get_attribute($this->env, $this->source, $context["guia"], "nroDoc", [], "any", false, false, false, 37);
                echo "</cbc:ID>
        <cbc:DocumentTypeCode>";
                // line 38
                echo twig_get_attribute($this->env, $this->source, $context["guia"], "tipoDoc", [], "any", false, false, false, 38);
                echo "</cbc:DocumentTypeCode>
    </cac:DespatchDocumentReference>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['guia'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 41
            echo "    ";
        }
        // line 42
        echo "    ";
        if (twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "relDocs", [], "any", false, false, false, 42)) {
            // line 43
            echo "    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "relDocs", [], "any", false, false, false, 43));
            foreach ($context['_seq'] as $context["_key"] => $context["rel"]) {
                // line 44
                echo "    <cac:AdditionalDocumentReference>
        <cbc:ID>";
                // line 45
                echo twig_get_attribute($this->env, $this->source, $context["rel"], "nroDoc", [], "any", false, false, false, 45);
                echo "</cbc:ID>
        <cbc:DocumentTypeCode>";
                // line 46
                echo twig_get_attribute($this->env, $this->source, $context["rel"], "tipoDoc", [], "any", false, false, false, 46);
                echo "</cbc:DocumentTypeCode>
    </cac:AdditionalDocumentReference>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['rel'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 49
            echo "    ";
        }
        // line 50
        echo "    ";
        $context["emp"] = twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "company", [], "any", false, false, false, 50);
        // line 51
        echo "    <cac:Signature>
        <cbc:ID>";
        // line 52
        echo twig_get_attribute($this->env, $this->source, ($context["emp"] ?? null), "ruc", [], "any", false, false, false, 52);
        echo "</cbc:ID>
        <cac:SignatoryParty>
            <cac:PartyIdentification>
                <cbc:ID>";
        // line 55
        echo twig_get_attribute($this->env, $this->source, ($context["emp"] ?? null), "ruc", [], "any", false, false, false, 55);
        echo "</cbc:ID>
            </cac:PartyIdentification>
            <cac:PartyName>
                <cbc:Name><![CDATA[";
        // line 58
        echo twig_get_attribute($this->env, $this->source, ($context["emp"] ?? null), "razonSocial", [], "any", false, false, false, 58);
        echo "]]></cbc:Name>
            </cac:PartyName>
        </cac:SignatoryParty>
        <cac:DigitalSignatureAttachment>
            <cac:ExternalReference>
                <cbc:URI>#GREENTER-SIGN</cbc:URI>
            </cac:ExternalReference>
        </cac:DigitalSignatureAttachment>
    </cac:Signature>
    <cac:AccountingSupplierParty>
        <cac:Party>
            <cac:PartyIdentification>
                <cbc:ID schemeID=\"6\">";
        // line 70
        echo twig_get_attribute($this->env, $this->source, ($context["emp"] ?? null), "ruc", [], "any", false, false, false, 70);
        echo "</cbc:ID>
            </cac:PartyIdentification>
            <cac:PartyName>
                <cbc:Name><![CDATA[";
        // line 73
        echo twig_get_attribute($this->env, $this->source, ($context["emp"] ?? null), "nombreComercial", [], "any", false, false, false, 73);
        echo "]]></cbc:Name>
            </cac:PartyName>
            <cac:PartyLegalEntity>
                <cbc:RegistrationName><![CDATA[";
        // line 76
        echo twig_get_attribute($this->env, $this->source, ($context["emp"] ?? null), "razonSocial", [], "any", false, false, false, 76);
        echo "]]></cbc:RegistrationName>
                ";
        // line 77
        $context["addr"] = twig_get_attribute($this->env, $this->source, ($context["emp"] ?? null), "address", [], "any", false, false, false, 77);
        // line 78
        echo "                <cac:RegistrationAddress>
                    <cbc:ID>";
        // line 79
        echo twig_get_attribute($this->env, $this->source, ($context["addr"] ?? null), "ubigueo", [], "any", false, false, false, 79);
        echo "</cbc:ID>
                    <cbc:AddressTypeCode>";
        // line 80
        echo twig_get_attribute($this->env, $this->source, ($context["addr"] ?? null), "codLocal", [], "any", false, false, false, 80);
        echo "</cbc:AddressTypeCode>
                    ";
        // line 81
        if (twig_get_attribute($this->env, $this->source, ($context["addr"] ?? null), "urbanizacion", [], "any", false, false, false, 81)) {
            // line 82
            echo "                    <cbc:CitySubdivisionName>";
            echo twig_get_attribute($this->env, $this->source, ($context["addr"] ?? null), "urbanizacion", [], "any", false, false, false, 82);
            echo "</cbc:CitySubdivisionName>
                    ";
        }
        // line 84
        echo "                    <cbc:CityName>";
        echo twig_get_attribute($this->env, $this->source, ($context["addr"] ?? null), "provincia", [], "any", false, false, false, 84);
        echo "</cbc:CityName>
                    <cbc:CountrySubentity>";
        // line 85
        echo twig_get_attribute($this->env, $this->source, ($context["addr"] ?? null), "departamento", [], "any", false, false, false, 85);
        echo "</cbc:CountrySubentity>
                    <cbc:District>";
        // line 86
        echo twig_get_attribute($this->env, $this->source, ($context["addr"] ?? null), "distrito", [], "any", false, false, false, 86);
        echo "</cbc:District>
                    <cac:AddressLine>
                        <cbc:Line><![CDATA[";
        // line 88
        echo twig_get_attribute($this->env, $this->source, ($context["addr"] ?? null), "direccion", [], "any", false, false, false, 88);
        echo "]]></cbc:Line>
                    </cac:AddressLine>
                    <cac:Country>
                        <cbc:IdentificationCode>";
        // line 91
        echo twig_get_attribute($this->env, $this->source, ($context["addr"] ?? null), "codigoPais", [], "any", false, false, false, 91);
        echo "</cbc:IdentificationCode>
                    </cac:Country>
                </cac:RegistrationAddress>
            </cac:PartyLegalEntity>
            ";
        // line 95
        if ((twig_get_attribute($this->env, $this->source, ($context["emp"] ?? null), "email", [], "any", false, false, false, 95) || twig_get_attribute($this->env, $this->source, ($context["emp"] ?? null), "telephone", [], "any", false, false, false, 95))) {
            // line 96
            echo "                <cac:Contact>
                    ";
            // line 97
            if (twig_get_attribute($this->env, $this->source, ($context["emp"] ?? null), "telephone", [], "any", false, false, false, 97)) {
                // line 98
                echo "                        <cbc:Telephone>";
                echo twig_get_attribute($this->env, $this->source, ($context["emp"] ?? null), "telephone", [], "any", false, false, false, 98);
                echo "</cbc:Telephone>
                    ";
            }
            // line 100
            echo "                    ";
            if (twig_get_attribute($this->env, $this->source, ($context["emp"] ?? null), "email", [], "any", false, false, false, 100)) {
                // line 101
                echo "                        <cbc:ElectronicMail>";
                echo twig_get_attribute($this->env, $this->source, ($context["emp"] ?? null), "email", [], "any", false, false, false, 101);
                echo "</cbc:ElectronicMail>
                    ";
            }
            // line 103
            echo "                </cac:Contact>
            ";
        }
        // line 105
        echo "        </cac:Party>
    </cac:AccountingSupplierParty>
    ";
        // line 107
        $context["client"] = twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "client", [], "any", false, false, false, 107);
        // line 108
        echo "    <cac:AccountingCustomerParty>
        <cac:Party>
            <cac:PartyIdentification>
                <cbc:ID schemeID=\"";
        // line 111
        echo twig_get_attribute($this->env, $this->source, ($context["client"] ?? null), "tipoDoc", [], "any", false, false, false, 111);
        echo "\">";
        echo twig_get_attribute($this->env, $this->source, ($context["client"] ?? null), "numDoc", [], "any", false, false, false, 111);
        echo "</cbc:ID>
            </cac:PartyIdentification>
            <cac:PartyLegalEntity>
                <cbc:RegistrationName><![CDATA[";
        // line 114
        echo twig_get_attribute($this->env, $this->source, ($context["client"] ?? null), "rznSocial", [], "any", false, false, false, 114);
        echo "]]></cbc:RegistrationName>
                ";
        // line 115
        if (twig_get_attribute($this->env, $this->source, ($context["client"] ?? null), "address", [], "any", false, false, false, 115)) {
            // line 116
            echo "                    ";
            $context["addr"] = twig_get_attribute($this->env, $this->source, ($context["client"] ?? null), "address", [], "any", false, false, false, 116);
            // line 117
            echo "                    <cac:RegistrationAddress>
                        ";
            // line 118
            if (twig_get_attribute($this->env, $this->source, ($context["addr"] ?? null), "ubigueo", [], "any", false, false, false, 118)) {
                // line 119
                echo "                            <cbc:ID>";
                echo twig_get_attribute($this->env, $this->source, ($context["addr"] ?? null), "ubigueo", [], "any", false, false, false, 119);
                echo "</cbc:ID>
                        ";
            }
            // line 121
            echo "                        <cac:AddressLine>
                            <cbc:Line><![CDATA[";
            // line 122
            echo twig_get_attribute($this->env, $this->source, ($context["addr"] ?? null), "direccion", [], "any", false, false, false, 122);
            echo "]]></cbc:Line>
                        </cac:AddressLine>
                        <cac:Country>
                            <cbc:IdentificationCode>";
            // line 125
            echo twig_get_attribute($this->env, $this->source, ($context["addr"] ?? null), "codigoPais", [], "any", false, false, false, 125);
            echo "</cbc:IdentificationCode>
                        </cac:Country>
                    </cac:RegistrationAddress>
                ";
        }
        // line 129
        echo "            </cac:PartyLegalEntity>
            ";
        // line 130
        if ((twig_get_attribute($this->env, $this->source, ($context["client"] ?? null), "email", [], "any", false, false, false, 130) || twig_get_attribute($this->env, $this->source, ($context["client"] ?? null), "telephone", [], "any", false, false, false, 130))) {
            // line 131
            echo "                <cac:Contact>
                    ";
            // line 132
            if (twig_get_attribute($this->env, $this->source, ($context["client"] ?? null), "telephone", [], "any", false, false, false, 132)) {
                // line 133
                echo "                        <cbc:Telephone>";
                echo twig_get_attribute($this->env, $this->source, ($context["client"] ?? null), "telephone", [], "any", false, false, false, 133);
                echo "</cbc:Telephone>
                    ";
            }
            // line 135
            echo "                    ";
            if (twig_get_attribute($this->env, $this->source, ($context["client"] ?? null), "email", [], "any", false, false, false, 135)) {
                // line 136
                echo "                        <cbc:ElectronicMail>";
                echo twig_get_attribute($this->env, $this->source, ($context["client"] ?? null), "email", [], "any", false, false, false, 136);
                echo "</cbc:ElectronicMail>
                    ";
            }
            // line 138
            echo "                </cac:Contact>
            ";
        }
        // line 140
        echo "        </cac:Party>
    </cac:AccountingCustomerParty>
    ";
        // line 142
        if (twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "formaPago", [], "any", false, false, false, 142)) {
            // line 143
            echo "    <cac:PaymentTerms>
        <cbc:ID>FormaPago</cbc:ID>
        <cbc:PaymentMeansID>";
            // line 145
            echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "formaPago", [], "any", false, false, false, 145), "tipo", [], "any", false, false, false, 145);
            echo "</cbc:PaymentMeansID>
        ";
            // line 146
            if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "formaPago", [], "any", false, false, false, 146), "monto", [], "any", false, false, false, 146)) {
                // line 147
                echo "        <cbc:Amount currencyID=\"";
                echo ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "formaPago", [], "any", false, true, false, 147), "moneda", [], "any", true, true, false, 147)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "formaPago", [], "any", false, true, false, 147), "moneda", [], "any", false, false, false, 147), twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 147))) : (twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 147)));
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "formaPago", [], "any", false, false, false, 147), "monto", [], "any", false, false, false, 147);
                echo "</cbc:Amount>
        ";
            }
            // line 149
            echo "    </cac:PaymentTerms>
    ";
        }
        // line 151
        echo "    ";
        if (twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "cuotas", [], "any", false, false, false, 151)) {
            // line 152
            echo "    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "cuotas", [], "any", false, false, false, 152));
            $context['loop'] = [
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            ];
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["cuota"]) {
                // line 153
                echo "    <cac:PaymentTerms>
        <cbc:ID>FormaPago</cbc:ID>
        <cbc:PaymentMeansID>Cuota";
                // line 155
                echo sprintf("%03d", twig_get_attribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, false, 155));
                echo "</cbc:PaymentMeansID>
        <cbc:Amount currencyID=\"";
                // line 156
                echo ((twig_get_attribute($this->env, $this->source, $context["cuota"], "moneda", [], "any", true, true, false, 156)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, $context["cuota"], "moneda", [], "any", false, false, false, 156), twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 156))) : (twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 156)));
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["cuota"], "monto", [], "any", false, false, false, 156);
                echo "</cbc:Amount>
        <cbc:PaymentDueDate>";
                // line 157
                echo twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["cuota"], "fechaPago", [], "any", false, false, false, 157), "Y-m-d");
                echo "</cbc:PaymentDueDate>
    </cac:PaymentTerms>
    ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['length'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['cuota'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 160
            echo "    ";
        }
        // line 161
        echo "    <cac:TaxTotal>
        <cbc:TaxAmount currencyID=\"";
        // line 162
        echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 162);
        echo "\">";
        echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "totalImpuestos", [], "any", false, false, false, 162)]);
        echo "</cbc:TaxAmount>
        ";
        // line 163
        if (twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoISC", [], "any", false, false, false, 163)) {
            // line 164
            echo "            <cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 165
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 165);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoBaseIsc", [], "any", false, false, false, 165)]);
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 166
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 166);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoISC", [], "any", false, false, false, 166)]);
            echo "</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cac:TaxScheme>
                        <cbc:ID>2000</cbc:ID>
                        <cbc:Name>ISC</cbc:Name>
                        <cbc:TaxTypeCode>EXC</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
        ";
        }
        // line 176
        echo "        ";
        if (twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoOperGravadas", [], "any", false, false, false, 176)) {
            // line 177
            echo "            <cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 178
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 178);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoOperGravadas", [], "any", false, false, false, 178)]);
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 179
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 179);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoIGV", [], "any", false, false, false, 179)]);
            echo "</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cac:TaxScheme>
                        <cbc:ID>1000</cbc:ID>
                        <cbc:Name>IGV</cbc:Name>
                        <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
        ";
        }
        // line 189
        echo "        ";
        if (twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoOperInafectas", [], "any", false, false, false, 189)) {
            // line 190
            echo "            <cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 191
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 191);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoOperInafectas", [], "any", false, false, false, 191)]);
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 192
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 192);
            echo "\">0</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cac:TaxScheme>
                        <cbc:ID>9998</cbc:ID>
                        <cbc:Name>INA</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
        ";
        }
        // line 202
        echo "        ";
        if (twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoOperExoneradas", [], "any", false, false, false, 202)) {
            // line 203
            echo "            <cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 204
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 204);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoOperExoneradas", [], "any", false, false, false, 204)]);
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 205
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 205);
            echo "\">0</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cac:TaxScheme>
                        <cbc:ID>9997</cbc:ID>
                        <cbc:Name>EXO</cbc:Name>
                        <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
        ";
        }
        // line 215
        echo "        ";
        if (twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoOperGratuitas", [], "any", false, false, false, 215)) {
            // line 216
            echo "            <cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 217
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 217);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoOperGratuitas", [], "any", false, false, false, 217)]);
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 218
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 218);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoIGVGratuitas", [], "any", false, false, false, 218)]);
            echo "</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cac:TaxScheme>
                        <cbc:ID>9996</cbc:ID>
                        <cbc:Name>GRA</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
        ";
        }
        // line 228
        echo "        ";
        if (twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoOperExportacion", [], "any", false, false, false, 228)) {
            // line 229
            echo "            <cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 230
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 230);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoOperExportacion", [], "any", false, false, false, 230)]);
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 231
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 231);
            echo "\">0</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cac:TaxScheme>
                        <cbc:ID>9995</cbc:ID>
                        <cbc:Name>EXP</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
        ";
        }
        // line 241
        echo "        ";
        if (twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoIvap", [], "any", false, false, false, 241)) {
            // line 242
            echo "            <cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 243
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 243);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoBaseIvap", [], "any", false, false, false, 243)]);
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 244
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 244);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoIvap", [], "any", false, false, false, 244)]);
            echo "</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cac:TaxScheme>
                        <cbc:ID>1016</cbc:ID>
                        <cbc:Name>IVAP</cbc:Name>
                        <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
        ";
        }
        // line 254
        echo "        ";
        if (twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoOtrosTributos", [], "any", false, false, false, 254)) {
            // line 255
            echo "            <cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 256
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 256);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoBaseOth", [], "any", false, false, false, 256)]);
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 257
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 257);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoOtrosTributos", [], "any", false, false, false, 257)]);
            echo "</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cac:TaxScheme>
                        <cbc:ID>9999</cbc:ID>
                        <cbc:Name>OTROS</cbc:Name>
                        <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
        ";
        }
        // line 267
        echo "        ";
        if (twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "icbper", [], "any", false, false, false, 267)) {
            // line 268
            echo "            <cac:TaxSubtotal>
                <cbc:TaxAmount currencyID=\"";
            // line 269
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 269);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "icbper", [], "any", false, false, false, 269)]);
            echo "</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cac:TaxScheme>
                        <cbc:ID>7152</cbc:ID>
                        <cbc:Name>ICBPER</cbc:Name>
                        <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
        ";
        }
        // line 279
        echo "    </cac:TaxTotal>
    <cac:LegalMonetaryTotal>
        ";
        // line 281
        if ( !(null === twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "sumOtrosCargos", [], "any", false, false, false, 281))) {
            // line 282
            echo "        <cbc:ChargeTotalAmount currencyID=\"";
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 282);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "sumOtrosCargos", [], "any", false, false, false, 282)]);
            echo "</cbc:ChargeTotalAmount>
        ";
        }
        // line 284
        echo "        ";
        if ( !(null === twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "redondeo", [], "any", false, false, false, 284))) {
            // line 285
            echo "        <cbc:PayableRoundingAmount currencyID=\"";
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 285);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "redondeo", [], "any", false, false, false, 285)]);
            echo "</cbc:PayableRoundingAmount>
        ";
        }
        // line 287
        echo "        <cbc:PayableAmount currencyID=\"";
        echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 287);
        echo "\">";
        echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "mtoImpVenta", [], "any", false, false, false, 287)]);
        echo "</cbc:PayableAmount>
    </cac:LegalMonetaryTotal>
    ";
        // line 289
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "details", [], "any", false, false, false, 289));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["detail"]) {
            // line 290
            echo "    <cac:CreditNoteLine>
        <cbc:ID>";
            // line 291
            echo twig_get_attribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, false, 291);
            echo "</cbc:ID>
        <cbc:CreditedQuantity unitCode=\"";
            // line 292
            echo twig_get_attribute($this->env, $this->source, $context["detail"], "unidad", [], "any", false, false, false, 292);
            echo "\">";
            echo twig_get_attribute($this->env, $this->source, $context["detail"], "cantidad", [], "any", false, false, false, 292);
            echo "</cbc:CreditedQuantity>
        <cbc:LineExtensionAmount currencyID=\"";
            // line 293
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 293);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, $context["detail"], "mtoValorVenta", [], "any", false, false, false, 293)]);
            echo "</cbc:LineExtensionAmount>
        <cac:PricingReference>
            ";
            // line 295
            if (twig_get_attribute($this->env, $this->source, $context["detail"], "mtoValorGratuito", [], "any", false, false, false, 295)) {
                // line 296
                echo "            <cac:AlternativeConditionPrice>
                <cbc:PriceAmount currencyID=\"";
                // line 297
                echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 297);
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format_limit')->getCallable(), [twig_get_attribute($this->env, $this->source, $context["detail"], "mtoValorGratuito", [], "any", false, false, false, 297), 10]);
                echo "</cbc:PriceAmount>
                <cbc:PriceTypeCode>02</cbc:PriceTypeCode>
            </cac:AlternativeConditionPrice>
            ";
            } else {
                // line 301
                echo "            <cac:AlternativeConditionPrice>
                <cbc:PriceAmount currencyID=\"";
                // line 302
                echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 302);
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format_limit')->getCallable(), [twig_get_attribute($this->env, $this->source, $context["detail"], "mtoPrecioUnitario", [], "any", false, false, false, 302), 10]);
                echo "</cbc:PriceAmount>
                <cbc:PriceTypeCode>01</cbc:PriceTypeCode>
            </cac:AlternativeConditionPrice>
            ";
            }
            // line 306
            echo "        </cac:PricingReference>
        <cac:TaxTotal>
            <cbc:TaxAmount currencyID=\"";
            // line 308
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 308);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, $context["detail"], "totalImpuestos", [], "any", false, false, false, 308)]);
            echo "</cbc:TaxAmount>
            ";
            // line 309
            if (twig_get_attribute($this->env, $this->source, $context["detail"], "isc", [], "any", false, false, false, 309)) {
                // line 310
                echo "            <cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
                // line 311
                echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 311);
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, $context["detail"], "mtoBaseIsc", [], "any", false, false, false, 311)]);
                echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
                // line 312
                echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 312);
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, $context["detail"], "isc", [], "any", false, false, false, 312)]);
                echo "</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cbc:Percent>";
                // line 314
                echo twig_get_attribute($this->env, $this->source, $context["detail"], "porcentajeIsc", [], "any", false, false, false, 314);
                echo "</cbc:Percent>
                    <cbc:TierRange>";
                // line 315
                echo twig_get_attribute($this->env, $this->source, $context["detail"], "tipSisIsc", [], "any", false, false, false, 315);
                echo "</cbc:TierRange>
                    <cac:TaxScheme>
                        <cbc:ID>2000</cbc:ID>
                        <cbc:Name>ISC</cbc:Name>
                        <cbc:TaxTypeCode>EXC</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
            ";
            }
            // line 324
            echo "            <cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 325
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 325);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, $context["detail"], "mtoBaseIgv", [], "any", false, false, false, 325)]);
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 326
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 326);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, $context["detail"], "igv", [], "any", false, false, false, 326)]);
            echo "</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cbc:Percent>";
            // line 328
            echo twig_get_attribute($this->env, $this->source, $context["detail"], "porcentajeIgv", [], "any", false, false, false, 328);
            echo "</cbc:Percent>
                    <cbc:TaxExemptionReasonCode>";
            // line 329
            echo twig_get_attribute($this->env, $this->source, $context["detail"], "tipAfeIgv", [], "any", false, false, false, 329);
            echo "</cbc:TaxExemptionReasonCode>
                    ";
            // line 330
            $context["afect"] = Greenter\Xml\Filter\TributoFunction::getByAfectacion(twig_get_attribute($this->env, $this->source, $context["detail"], "tipAfeIgv", [], "any", false, false, false, 330));
            // line 331
            echo "                    <cac:TaxScheme>
                        <cbc:ID>";
            // line 332
            echo twig_get_attribute($this->env, $this->source, ($context["afect"] ?? null), "id", [], "any", false, false, false, 332);
            echo "</cbc:ID>
                        <cbc:Name>";
            // line 333
            echo twig_get_attribute($this->env, $this->source, ($context["afect"] ?? null), "name", [], "any", false, false, false, 333);
            echo "</cbc:Name>
                        <cbc:TaxTypeCode>";
            // line 334
            echo twig_get_attribute($this->env, $this->source, ($context["afect"] ?? null), "code", [], "any", false, false, false, 334);
            echo "</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
            ";
            // line 338
            if (twig_get_attribute($this->env, $this->source, $context["detail"], "otroTributo", [], "any", false, false, false, 338)) {
                // line 339
                echo "            <cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
                // line 340
                echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 340);
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, $context["detail"], "mtoBaseOth", [], "any", false, false, false, 340)]);
                echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
                // line 341
                echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 341);
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, $context["detail"], "otroTributo", [], "any", false, false, false, 341)]);
                echo "</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cbc:Percent>";
                // line 343
                echo twig_get_attribute($this->env, $this->source, $context["detail"], "porcentajeOth", [], "any", false, false, false, 343);
                echo "</cbc:Percent>
                    <cac:TaxScheme>
                        <cbc:ID>9999</cbc:ID>
                        <cbc:Name>OTROS</cbc:Name>
                        <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
            ";
            }
            // line 352
            echo "            ";
            if (twig_get_attribute($this->env, $this->source, $context["detail"], "icbper", [], "any", false, false, false, 352)) {
                // line 353
                echo "            <cac:TaxSubtotal>
                <cbc:TaxAmount currencyID=\"";
                // line 354
                echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 354);
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, $context["detail"], "icbper", [], "any", false, false, false, 354)]);
                echo "</cbc:TaxAmount>
                <cbc:BaseUnitMeasure unitCode=\"";
                // line 355
                echo twig_get_attribute($this->env, $this->source, $context["detail"], "unidad", [], "any", false, false, false, 355);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["detail"], "cantidad", [], "any", false, false, false, 355);
                echo "</cbc:BaseUnitMeasure>
                <cac:TaxCategory>
                    <cbc:PerUnitAmount currencyID=\"";
                // line 357
                echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 357);
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), [twig_get_attribute($this->env, $this->source, $context["detail"], "factorIcbper", [], "any", false, false, false, 357)]);
                echo "</cbc:PerUnitAmount>
                    <cac:TaxScheme>
                        <cbc:ID>7152</cbc:ID>
                        <cbc:Name>ICBPER</cbc:Name>
                        <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
            ";
            }
            // line 366
            echo "        </cac:TaxTotal>
        <cac:Item>
            <cbc:Description><![CDATA[";
            // line 368
            echo twig_get_attribute($this->env, $this->source, $context["detail"], "descripcion", [], "any", false, false, false, 368);
            echo "]]></cbc:Description>
            ";
            // line 369
            if (twig_get_attribute($this->env, $this->source, $context["detail"], "codProducto", [], "any", false, false, false, 369)) {
                // line 370
                echo "                <cac:SellersItemIdentification>
                    <cbc:ID>";
                // line 371
                echo twig_get_attribute($this->env, $this->source, $context["detail"], "codProducto", [], "any", false, false, false, 371);
                echo "</cbc:ID>
                </cac:SellersItemIdentification>
            ";
            }
            // line 374
            echo "            ";
            if (twig_get_attribute($this->env, $this->source, $context["detail"], "codProdGS1", [], "any", false, false, false, 374)) {
                // line 375
                echo "                <cac:StandardItemIdentification>
                    <cbc:ID>";
                // line 376
                echo twig_get_attribute($this->env, $this->source, $context["detail"], "codProdGS1", [], "any", false, false, false, 376);
                echo "</cbc:ID>
                </cac:StandardItemIdentification>
            ";
            }
            // line 379
            echo "            ";
            if (twig_get_attribute($this->env, $this->source, $context["detail"], "codProdSunat", [], "any", false, false, false, 379)) {
                // line 380
                echo "                <cac:CommodityClassification>
                    <cbc:ItemClassificationCode>";
                // line 381
                echo twig_get_attribute($this->env, $this->source, $context["detail"], "codProdSunat", [], "any", false, false, false, 381);
                echo "</cbc:ItemClassificationCode>
                </cac:CommodityClassification>
            ";
            }
            // line 384
            echo "            ";
            if (twig_get_attribute($this->env, $this->source, $context["detail"], "atributos", [], "any", false, false, false, 384)) {
                // line 385
                echo "                ";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["detail"], "atributos", [], "any", false, false, false, 385));
                foreach ($context['_seq'] as $context["_key"] => $context["atr"]) {
                    // line 386
                    echo "                    <cac:AdditionalItemProperty >
                        <cbc:Name>";
                    // line 387
                    echo twig_get_attribute($this->env, $this->source, $context["atr"], "name", [], "any", false, false, false, 387);
                    echo "</cbc:Name>
                        <cbc:NameCode>";
                    // line 388
                    echo twig_get_attribute($this->env, $this->source, $context["atr"], "code", [], "any", false, false, false, 388);
                    echo "</cbc:NameCode>
                        ";
                    // line 389
                    if (twig_get_attribute($this->env, $this->source, $context["atr"], "value", [], "any", false, false, false, 389)) {
                        // line 390
                        echo "                            <cbc:Value>";
                        echo twig_get_attribute($this->env, $this->source, $context["atr"], "value", [], "any", false, false, false, 390);
                        echo "</cbc:Value>
                        ";
                    }
                    // line 392
                    echo "                        ";
                    if (((twig_get_attribute($this->env, $this->source, $context["atr"], "fecInicio", [], "any", false, false, false, 392) || twig_get_attribute($this->env, $this->source, $context["atr"], "fecFin", [], "any", false, false, false, 392)) || twig_get_attribute($this->env, $this->source, $context["atr"], "duracion", [], "any", false, false, false, 392))) {
                        // line 393
                        echo "                            <cac:UsabilityPeriod>
                                ";
                        // line 394
                        if (twig_get_attribute($this->env, $this->source, $context["atr"], "fecInicio", [], "any", false, false, false, 394)) {
                            // line 395
                            echo "                                    <cbc:StartDate>";
                            echo twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["atr"], "fecInicio", [], "any", false, false, false, 395), "Y-m-d");
                            echo "</cbc:StartDate>
                                ";
                        }
                        // line 397
                        echo "                                ";
                        if (twig_get_attribute($this->env, $this->source, $context["atr"], "fecFin", [], "any", false, false, false, 397)) {
                            // line 398
                            echo "                                    <cbc:EndDate>";
                            echo twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["atr"], "fecFin", [], "any", false, false, false, 398), "Y-m-d");
                            echo "</cbc:EndDate>
                                ";
                        }
                        // line 400
                        echo "                                ";
                        if (twig_get_attribute($this->env, $this->source, $context["atr"], "duracion", [], "any", false, false, false, 400)) {
                            // line 401
                            echo "                                    <cbc:DurationMeasure unitCode=\"DAY\">";
                            echo twig_get_attribute($this->env, $this->source, $context["atr"], "duracion", [], "any", false, false, false, 401);
                            echo "</cbc:DurationMeasure>
                                ";
                        }
                        // line 403
                        echo "                            </cac:UsabilityPeriod>
                        ";
                    }
                    // line 405
                    echo "                    </cac:AdditionalItemProperty>
                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['atr'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 407
                echo "            ";
            }
            // line 408
            echo "        </cac:Item>
        <cac:Price>
            <cbc:PriceAmount currencyID=\"";
            // line 410
            echo twig_get_attribute($this->env, $this->source, ($context["doc"] ?? null), "tipoMoneda", [], "any", false, false, false, 410);
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format_limit')->getCallable(), [twig_get_attribute($this->env, $this->source, $context["detail"], "mtoValorUnitario", [], "any", false, false, false, 410), 10]);
            echo "</cbc:PriceAmount>
        </cac:Price>
    </cac:CreditNoteLine>
    ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['detail'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 414
        echo "</CreditNote>
";
        $___internal_19f007d5a663599243585cdabaf8397cb03d63929880a3177e4806c5b7a870cb_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 1
        echo twig_spaceless($___internal_19f007d5a663599243585cdabaf8397cb03d63929880a3177e4806c5b7a870cb_);
    }

    public function getTemplateName()
    {
        return "notacr2.1.xml.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1096 => 1,  1092 => 414,  1072 => 410,  1068 => 408,  1065 => 407,  1058 => 405,  1054 => 403,  1048 => 401,  1045 => 400,  1039 => 398,  1036 => 397,  1030 => 395,  1028 => 394,  1025 => 393,  1022 => 392,  1016 => 390,  1014 => 389,  1010 => 388,  1006 => 387,  1003 => 386,  998 => 385,  995 => 384,  989 => 381,  986 => 380,  983 => 379,  977 => 376,  974 => 375,  971 => 374,  965 => 371,  962 => 370,  960 => 369,  956 => 368,  952 => 366,  938 => 357,  931 => 355,  925 => 354,  922 => 353,  919 => 352,  907 => 343,  900 => 341,  894 => 340,  891 => 339,  889 => 338,  882 => 334,  878 => 333,  874 => 332,  871 => 331,  869 => 330,  865 => 329,  861 => 328,  854 => 326,  848 => 325,  845 => 324,  833 => 315,  829 => 314,  822 => 312,  816 => 311,  813 => 310,  811 => 309,  805 => 308,  801 => 306,  792 => 302,  789 => 301,  780 => 297,  777 => 296,  775 => 295,  768 => 293,  762 => 292,  758 => 291,  755 => 290,  738 => 289,  730 => 287,  722 => 285,  719 => 284,  711 => 282,  709 => 281,  705 => 279,  690 => 269,  687 => 268,  684 => 267,  669 => 257,  663 => 256,  660 => 255,  657 => 254,  642 => 244,  636 => 243,  633 => 242,  630 => 241,  617 => 231,  611 => 230,  608 => 229,  605 => 228,  590 => 218,  584 => 217,  581 => 216,  578 => 215,  565 => 205,  559 => 204,  556 => 203,  553 => 202,  540 => 192,  534 => 191,  531 => 190,  528 => 189,  513 => 179,  507 => 178,  504 => 177,  501 => 176,  486 => 166,  480 => 165,  477 => 164,  475 => 163,  469 => 162,  466 => 161,  463 => 160,  446 => 157,  440 => 156,  436 => 155,  432 => 153,  414 => 152,  411 => 151,  407 => 149,  399 => 147,  397 => 146,  393 => 145,  389 => 143,  387 => 142,  383 => 140,  379 => 138,  373 => 136,  370 => 135,  364 => 133,  362 => 132,  359 => 131,  357 => 130,  354 => 129,  347 => 125,  341 => 122,  338 => 121,  332 => 119,  330 => 118,  327 => 117,  324 => 116,  322 => 115,  318 => 114,  310 => 111,  305 => 108,  303 => 107,  299 => 105,  295 => 103,  289 => 101,  286 => 100,  280 => 98,  278 => 97,  275 => 96,  273 => 95,  266 => 91,  260 => 88,  255 => 86,  251 => 85,  246 => 84,  240 => 82,  238 => 81,  234 => 80,  230 => 79,  227 => 78,  225 => 77,  221 => 76,  215 => 73,  209 => 70,  194 => 58,  188 => 55,  182 => 52,  179 => 51,  176 => 50,  173 => 49,  164 => 46,  160 => 45,  157 => 44,  152 => 43,  149 => 42,  146 => 41,  137 => 38,  133 => 37,  130 => 36,  125 => 35,  123 => 34,  117 => 31,  113 => 30,  109 => 28,  103 => 25,  100 => 24,  98 => 23,  93 => 21,  89 => 20,  85 => 19,  79 => 17,  68 => 15,  64 => 14,  60 => 13,  56 => 12,  50 => 11,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "notacr2.1.xml.twig", "C:\\xampp2\\htdocs\\CorporacionELIFE\\public\\FACT_WebService\\Facturacion\\vendor\\greenter\\greenter\\packages\\xml\\src\\Xml\\Templates\\notacr2.1.xml.twig");
    }
}
