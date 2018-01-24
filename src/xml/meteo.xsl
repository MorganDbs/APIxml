<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="xml" indent="yes" encoding="UTF-8" doctype-system="./meteo.dtd" />

    <xsl:template match="/">
        <xsl:apply-templates select="./previsions" />
    </xsl:template>

    <xsl:template match="previsions">
        <table class="bordered centered striped highlight responsive-table">
            <thead>
                <tr>
                <th>Heure</th>
                <th>Temperature</th>
                <th>Pluie</th>
                <th>Humidite</th>
                <th>Vent moyen</th>
                <th>Vent rafales</th>
                <th>Risque neige</th>
                <th>Nebulosite</th>
            </tr>
        </thead>
        <tbody>
            <xsl:apply-templates select="./echeance" />
        </tbody>
        </table>
    </xsl:template>

    <xsl:template match="echeance">
                <xsl:if test="((@hour = '6') or (@hour = '12') or (@hour = '18'))">
                    <tr>
                        <td>
                            <xsl:value-of select="@hour + 1" /> h
                        </td>

                        <td>
                            <xsl:apply-templates select="temperature" />
                        </td>

                        <td>
                            <xsl:attribute name="interval">
                                <xsl:value-of select="@interval" />
                            </xsl:attribute>
                            <xsl:apply-templates select="pluie" />
                        </td>

                        <td>
                            <xsl:apply-templates select="humidite" />
                        </td>

                        <td>
                            <xsl:apply-templates select="vent_moyen" />
                        </td>

                        <td>
                            <xsl:apply-templates select="vent_rafales" />
                        </td>

                        <td>
                            <xsl:apply-templates select="risque_neige" />
                        </td>

                        <td>
                            <xsl:apply-templates select="nebulosite" />
                        </td>
                    </tr>
                </xsl:if>
    </xsl:template>

    <xsl:template match="temperature">
        <xsl:value-of select="round(./level[@val = 'sol'] - 273.15)" /> °C
    </xsl:template>

    <xsl:template match="pluie">
        <xsl:value-of select="." /> mm
    </xsl:template>

    <xsl:template match="humidite">
        <xsl:value-of select="./level[@val = '2m']" /> %
    </xsl:template>

    <xsl:template match="vent_moyen">
        <xsl:value-of select="./level[@val = '10m']" /> km/h
    </xsl:template>

    <xsl:template match="vent_rafales">
        <xsl:value-of select="./level[@val = '10m']" /> km/h
    </xsl:template>

    <xsl:template match="risque_neige">
        <xsl:value-of select="." />
    </xsl:template>

    <xsl:template match="nebulosite">
        <xsl:variable name="nebulosite" select="./level[@val = 'moyenne']" />
        <xsl:if test="$nebulosite = 0">
            <xsl:text>Ciel serein</xsl:text>
        </xsl:if>
        <xsl:if test="($nebulosite > 0) and (25 > $nebulosite)">
            <xsl:text>Légèrement nuageux</xsl:text>
        </xsl:if>
        <xsl:if test="($nebulosite > 25) and (62 > $nebulosite)">
            <xsl:text>Partiellement nuageux</xsl:text>
        </xsl:if>
        <xsl:if test="($nebulosite > 62) and (85 > $nebulosite)">
            <xsl:text>Très nuageux</xsl:text>
        </xsl:if>
        <xsl:if test="($nebulosite > 85)">
            <xsl:text>Couvert</xsl:text>
        </xsl:if>
    </xsl:template>

    <xsl:template match="*/text()" />
</xsl:stylesheet>
