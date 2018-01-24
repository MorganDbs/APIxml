<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="xml" indent="yes" encoding="UTF-8" doctype-system="./meteo.dtd" />

    <xsl:template match="/">
        <previsions>
            <xsl:apply-templates select="./previsions" />
        </previsions>
    </xsl:template>

    <xsl:template match="previsions">
        <xsl:apply-templates select="./echeance" />
    </xsl:template>

    <xsl:template match="echeance">
        <xsl:if test="((@hour = '6') or (@hour = '12') or (@hour = '18'))">
            <echeance>
                <xsl:attribute name="hour">
                    <xsl:value-of select="@hour" />
                </xsl:attribute>
                <xsl:attribute name="timestamp">
                    <xsl:value-of select="@timestamp" />
                </xsl:attribute>

                <temperature>
                    <xsl:apply-templates select="temperature" />
                </temperature>
                <pluie>
                    <xsl:attribute name="interval">
                        <xsl:value-of select="@interval" />
                    </xsl:attribute>

                    <xsl:apply-templates select="pluie" />
                </pluie>
                <humidite>
                    <xsl:apply-templates select="humidite" />
                </humidite>
                <vent_moyen>
                    <xsl:apply-templates select="vent_moyen" />
                </vent_moyen>
                <vent_rafales>
                    <xsl:apply-templates select="vent_rafales" />
                </vent_rafales>
                <risque_neige>
                    <xsl:apply-templates select="risque_neige" />
                </risque_neige>
                <nebulosite>
                    <xsl:apply-templates select="nebulosite" />
                </nebulosite>
            </echeance>
        </xsl:if>
    </xsl:template>

    <xsl:template match="temperature">
        <xsl:value-of select="./level[@val = 'sol']" />
    </xsl:template>

    <xsl:template match="pluie">
        <xsl:value-of select="." />
    </xsl:template>

    <xsl:template match="humidite">
        <xsl:value-of select="./level[@val = '2m']" />
    </xsl:template>

    <xsl:template match="vent_moyen">
        <xsl:value-of select="./level[@val = '10m']" />
    </xsl:template>

    <xsl:template match="vent_rafales">
        <xsl:value-of select="./level[@val = '10m']" />
    </xsl:template>

    <xsl:template match="risque_neige">
        <xsl:value-of select="." />
    </xsl:template>

    <xsl:template match="nebulosite">
        <xsl:value-of select="./level[@val = 'moyenne']" />
    </xsl:template>

    <xsl:template match="*/text()" />
</xsl:stylesheet>