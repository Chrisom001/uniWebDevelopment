<?xml version="1.0" encoding="utf-8"?> 
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0" >
<xsl:output method="xml" version="1.0" omit-xml-declaration="yes" indent="yes" media-type="text/html"/>
    
<xsl:template match="/">
	<xsl:apply-templates select="rss/channel/item" /> 
</xsl:template>

<xsl:template match="item">
<html>
<body>
<p><xsl:apply-templates select="title" /></p>
<xsl:element name="a">
<xsl:attribute name="href">
<xsl:value-of select="link"/>
</xsl:attribute>
Go To BBC News
</xsl:element>
</body>
<br/>
</html>
</xsl:template> 

</xsl:stylesheet>
