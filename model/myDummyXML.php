<?php

class myDummyXML {

public $xml = <<<XML
<weatherdata>
<location>
<name>Gothenburg</name>
<type>Regional capital</type>
<country>Sweden</country>
<timezone id="Europe/Stockholm" utcoffsetMinutes="60"/>
<location altitude="10" latitude="57.70716" longitude="11.96679" geobase="geonames" geobaseid="2711537"/>
</location>
<credit>
<!--
In order to use the free weather data from yr no, you HAVE to display 
the following text clearly visible on your web page. The text should be a 
link to the specified URL.
-->
<!--
Please read more about our conditions and guidelines at http://om.yr.no/verdata/  English explanation at http://om.yr.no/verdata/free-weather-data/
-->
<link text="Weather forecast from yr.no, delivered by the Norwegian Meteorological Institute and the NRK" url="http://www.yr.no/place/Sweden/Västra_Götaland/Gothenburg/"/>
</credit>
<links>
<link id="xmlSource" url="http://www.yr.no/place/Sweden/Västra_Götaland/Gothenburg/forecast.xml"/>
<link id="xmlSourceHourByHour" url="http://www.yr.no/place/Sweden/Västra_Götaland/Gothenburg/forecast_hour_by_hour.xml"/>
<link id="overview" url="http://www.yr.no/place/Sweden/Västra_Götaland/Gothenburg/"/>
<link id="hourByHour" url="http://www.yr.no/place/Sweden/Västra_Götaland/Gothenburg/hour_by_hour"/>
<link id="longTermForecast" url="http://www.yr.no/place/Sweden/Västra_Götaland/Gothenburg/long"/>
</links>
<meta>
<lastupdate>2015-01-15T15:35:00</lastupdate>
<nextupdate>2015-01-15T23:00:00</nextupdate>
</meta>
<sun rise="2015-01-15T08:44:06" set="2015-01-15T15:59:13"/>
<forecast>
<tabular>
<time from="2015-01-15T19:00:00" to="2015-01-16T00:00:00" period="3">
<!--
 Valid from 2015-01-15T19:00:00 to 2015-01-16T00:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-15T19:00:00  -->
<windDirection deg="193.8" code="SSW" name="South-southwest"/>
<windSpeed mps="7.6" name="Moderate breeze"/>
<temperature unit="celsius" value="6"/>
<pressure unit="hPa" value="988.2"/>
</time>
<time from="2015-01-16T00:00:00" to="2015-01-16T06:00:00" period="0">
<!--
 Valid from 2015-01-16T00:00:00 to 2015-01-16T06:00:00 
-->
<symbol number="9" numberEx="9" name="Rain" var="09"/>
<precipitation value="1.0" minvalue="0.2" maxvalue="2.0"/>
<!--  Valid at 2015-01-16T00:00:00  -->
<windDirection deg="203.3" code="SSW" name="South-southwest"/>
<windSpeed mps="5.1" name="Gentle breeze"/>
<temperature unit="celsius" value="6"/>
<pressure unit="hPa" value="986.4"/>
</time>
<time from="2015-01-16T06:00:00" to="2015-01-16T12:00:00" period="1">
<!--
 Valid from 2015-01-16T06:00:00 to 2015-01-16T12:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-16T06:00:00  -->
<windDirection deg="200.7" code="SSW" name="South-southwest"/>
<windSpeed mps="10.5" name="Fresh breeze"/>
<temperature unit="celsius" value="5"/>
<pressure unit="hPa" value="986.6"/>
</time>
<time from="2015-01-16T12:00:00" to="2015-01-16T18:00:00" period="2">
<!--
 Valid from 2015-01-16T12:00:00 to 2015-01-16T18:00:00 
-->
<symbol number="3" numberEx="3" name="Partly cloudy" var="03d"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-16T12:00:00  -->
<windDirection deg="224.8" code="SW" name="Southwest"/>
<windSpeed mps="10.7" name="Fresh breeze"/>
<temperature unit="celsius" value="6"/>
<pressure unit="hPa" value="990.9"/>
</time>
<time from="2015-01-16T18:00:00" to="2015-01-17T00:00:00" period="3">
<!--
 Valid from 2015-01-16T18:00:00 to 2015-01-17T00:00:00 
-->
<symbol number="2" numberEx="2" name="Fair" var="mf/02n.86"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-16T18:00:00  -->
<windDirection deg="229.9" code="SW" name="Southwest"/>
<windSpeed mps="8.4" name="Fresh breeze"/>
<temperature unit="celsius" value="5"/>
<pressure unit="hPa" value="997.8"/>
</time>
<time from="2015-01-17T00:00:00" to="2015-01-17T06:00:00" period="0">
<!--
 Valid from 2015-01-17T00:00:00 to 2015-01-17T06:00:00 
-->
<symbol number="3" numberEx="3" name="Partly cloudy" var="mf/03n.89"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-17T00:00:00  -->
<windDirection deg="209.9" code="SSW" name="South-southwest"/>
<windSpeed mps="4.8" name="Gentle breeze"/>
<temperature unit="celsius" value="4"/>
<pressure unit="hPa" value="1002.1"/>
</time>
<time from="2015-01-17T06:00:00" to="2015-01-17T12:00:00" period="1">
<!--
 Valid from 2015-01-17T06:00:00 to 2015-01-17T12:00:00 
-->
<symbol number="3" numberEx="3" name="Partly cloudy" var="03d"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-17T06:00:00  -->
<windDirection deg="225.0" code="SW" name="Southwest"/>
<windSpeed mps="5.9" name="Moderate breeze"/>
<temperature unit="celsius" value="3"/>
<pressure unit="hPa" value="1002.1"/>
</time>
<time from="2015-01-17T12:00:00" to="2015-01-17T18:00:00" period="2">
<!--
 Valid from 2015-01-17T12:00:00 to 2015-01-17T18:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-17T12:00:00  -->
<windDirection deg="230.9" code="SW" name="Southwest"/>
<windSpeed mps="6.3" name="Moderate breeze"/>
<temperature unit="celsius" value="4"/>
<pressure unit="hPa" value="1004.8"/>
</time>
<time from="2015-01-17T18:00:00" to="2015-01-18T00:00:00" period="3">
<!--
 Valid from 2015-01-17T18:00:00 to 2015-01-18T00:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-17T18:00:00  -->
<windDirection deg="231.6" code="SW" name="Southwest"/>
<windSpeed mps="4.7" name="Gentle breeze"/>
<temperature unit="celsius" value="4"/>
<pressure unit="hPa" value="1007.2"/>
</time>
<time from="2015-01-18T00:00:00" to="2015-01-18T06:00:00" period="0">
<!--
 Valid from 2015-01-18T00:00:00 to 2015-01-18T06:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-18T00:00:00  -->
<windDirection deg="224.4" code="SW" name="Southwest"/>
<windSpeed mps="3.5" name="Gentle breeze"/>
<temperature unit="celsius" value="4"/>
<pressure unit="hPa" value="1010.0"/>
</time>
<time from="2015-01-18T07:00:00" to="2015-01-18T13:00:00" period="1">
<!--
 Valid from 2015-01-18T07:00:00 to 2015-01-18T13:00:00 
-->
<symbol number="13" numberEx="49" name="Light snow" var="49"/>
<precipitation value="0.7"/>
<!--  Valid at 2015-01-18T07:00:00  -->
<windDirection deg="147.5" code="SSE" name="South-southeast"/>
<windSpeed mps="2.4" name="Light breeze"/>
<temperature unit="celsius" value="1"/>
<pressure unit="hPa" value="1010.3"/>
</time>
<time from="2015-01-18T13:00:00" to="2015-01-18T19:00:00" period="2">
<!--
 Valid from 2015-01-18T13:00:00 to 2015-01-18T19:00:00 
-->
<symbol number="3" numberEx="3" name="Partly cloudy" var="03d"/>
<precipitation value="0.3"/>
<!--  Valid at 2015-01-18T13:00:00  -->
<windDirection deg="114.0" code="ESE" name="East-southeast"/>
<windSpeed mps="1.2" name="Light air"/>
<temperature unit="celsius" value="1"/>
<pressure unit="hPa" value="1010.2"/>
</time>
<time from="2015-01-18T19:00:00" to="2015-01-19T01:00:00" period="3">
<!--
 Valid from 2015-01-18T19:00:00 to 2015-01-19T01:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-18T19:00:00  -->
<windDirection deg="115.3" code="ESE" name="East-southeast"/>
<windSpeed mps="1.6" name="Light breeze"/>
<temperature unit="celsius" value="0"/>
<pressure unit="hPa" value="1011.0"/>
</time>
<time from="2015-01-19T01:00:00" to="2015-01-19T07:00:00" period="0">
<!--
 Valid from 2015-01-19T01:00:00 to 2015-01-19T07:00:00 
-->
<symbol number="13" numberEx="13" name="Snow" var="13"/>
<precipitation value="2.2"/>
<!--  Valid at 2015-01-19T01:00:00  -->
<windDirection deg="90.5" code="E" name="East"/>
<windSpeed mps="2.5" name="Light breeze"/>
<temperature unit="celsius" value="-1"/>
<pressure unit="hPa" value="1012.0"/>
</time>
<time from="2015-01-19T07:00:00" to="2015-01-19T13:00:00" period="1">
<!--
 Valid from 2015-01-19T07:00:00 to 2015-01-19T13:00:00 
-->
<symbol number="12" numberEx="12" name="Sleet" var="12"/>
<precipitation value="4.3"/>
<!--  Valid at 2015-01-19T07:00:00  -->
<windDirection deg="93.7" code="E" name="East"/>
<windSpeed mps="3.5" name="Gentle breeze"/>
<temperature unit="celsius" value="1"/>
<pressure unit="hPa" value="1009.3"/>
</time>
<time from="2015-01-19T13:00:00" to="2015-01-19T19:00:00" period="2">
<!--
 Valid from 2015-01-19T13:00:00 to 2015-01-19T19:00:00 
-->
<symbol number="13" numberEx="13" name="Snow" var="13"/>
<precipitation value="1.2"/>
<!--  Valid at 2015-01-19T13:00:00  -->
<windDirection deg="127.2" code="SE" name="Southeast"/>
<windSpeed mps="3.7" name="Gentle breeze"/>
<temperature unit="celsius" value="1"/>
<pressure unit="hPa" value="1008.3"/>
</time>
<time from="2015-01-19T19:00:00" to="2015-01-20T01:00:00" period="3">
<!--
 Valid from 2015-01-19T19:00:00 to 2015-01-20T01:00:00 
-->
<symbol number="13" numberEx="49" name="Light snow" var="49"/>
<precipitation value="0.8"/>
<!--  Valid at 2015-01-19T19:00:00  -->
<windDirection deg="125.0" code="SE" name="Southeast"/>
<windSpeed mps="3.1" name="Light breeze"/>
<temperature unit="celsius" value="1"/>
<pressure unit="hPa" value="1008.3"/>
</time>
<time from="2015-01-20T01:00:00" to="2015-01-20T07:00:00" period="0">
<!--
 Valid from 2015-01-20T01:00:00 to 2015-01-20T07:00:00 
-->
<symbol number="13" numberEx="13" name="Snow" var="13"/>
<precipitation value="1.9"/>
<!--  Valid at 2015-01-20T01:00:00  -->
<windDirection deg="103.4" code="ESE" name="East-southeast"/>
<windSpeed mps="2.5" name="Light breeze"/>
<temperature unit="celsius" value="0"/>
<pressure unit="hPa" value="1008.6"/>
</time>
<time from="2015-01-20T07:00:00" to="2015-01-20T13:00:00" period="1">
<!--
 Valid from 2015-01-20T07:00:00 to 2015-01-20T13:00:00 
-->
<symbol number="13" numberEx="13" name="Snow" var="13"/>
<precipitation value="1.3"/>
<!--  Valid at 2015-01-20T07:00:00  -->
<windDirection deg="82.5" code="E" name="East"/>
<windSpeed mps="2.9" name="Light breeze"/>
<temperature unit="celsius" value="0"/>
<pressure unit="hPa" value="1006.3"/>
</time>
<time from="2015-01-20T13:00:00" to="2015-01-20T19:00:00" period="2">
<!--
 Valid from 2015-01-20T13:00:00 to 2015-01-20T19:00:00 
-->
<symbol number="13" numberEx="49" name="Light snow" var="49"/>
<precipitation value="0.5"/>
<!--  Valid at 2015-01-20T13:00:00  -->
<windDirection deg="61.4" code="ENE" name="East-northeast"/>
<windSpeed mps="2.8" name="Light breeze"/>
<temperature unit="celsius" value="1"/>
<pressure unit="hPa" value="1004.8"/>
</time>
<time from="2015-01-20T19:00:00" to="2015-01-21T01:00:00" period="3">
<!--
 Valid from 2015-01-20T19:00:00 to 2015-01-21T01:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-20T19:00:00  -->
<windDirection deg="56.9" code="ENE" name="East-northeast"/>
<windSpeed mps="2.4" name="Light breeze"/>
<temperature unit="celsius" value="0"/>
<pressure unit="hPa" value="1004.5"/>
</time>
<time from="2015-01-21T01:00:00" to="2015-01-21T07:00:00" period="0">
<!--
 Valid from 2015-01-21T01:00:00 to 2015-01-21T07:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-21T01:00:00  -->
<windDirection deg="53.3" code="NE" name="Northeast"/>
<windSpeed mps="2.6" name="Light breeze"/>
<temperature unit="celsius" value="-1"/>
<pressure unit="hPa" value="1005.4"/>
</time>
<time from="2015-01-21T07:00:00" to="2015-01-21T13:00:00" period="1">
<!--
 Valid from 2015-01-21T07:00:00 to 2015-01-21T13:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-21T07:00:00  -->
<windDirection deg="60.0" code="ENE" name="East-northeast"/>
<windSpeed mps="3.9" name="Gentle breeze"/>
<temperature unit="celsius" value="-4"/>
<pressure unit="hPa" value="1005.3"/>
</time>
<time from="2015-01-21T13:00:00" to="2015-01-21T19:00:00" period="2">
<!--
 Valid from 2015-01-21T13:00:00 to 2015-01-21T19:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0.2"/>
<!--  Valid at 2015-01-21T13:00:00  -->
<windDirection deg="101.6" code="ESE" name="East-southeast"/>
<windSpeed mps="2.3" name="Light breeze"/>
<temperature unit="celsius" value="1"/>
<pressure unit="hPa" value="1006.7"/>
</time>
<time from="2015-01-21T19:00:00" to="2015-01-22T01:00:00" period="3">
<!--
 Valid from 2015-01-21T19:00:00 to 2015-01-22T01:00:00 
-->
<symbol number="3" numberEx="3" name="Partly cloudy" var="mf/03n.03"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-21T19:00:00  -->
<windDirection deg="91.3" code="E" name="East"/>
<windSpeed mps="2.5" name="Light breeze"/>
<temperature unit="celsius" value="-1"/>
<pressure unit="hPa" value="1008.0"/>
</time>
<time from="2015-01-22T01:00:00" to="2015-01-22T07:00:00" period="0">
<!--
 Valid from 2015-01-22T01:00:00 to 2015-01-22T07:00:00 
-->
<symbol number="3" numberEx="3" name="Partly cloudy" var="mf/03n.06"/>
<precipitation value="0.2"/>
<!--  Valid at 2015-01-22T01:00:00  -->
<windDirection deg="74.4" code="ENE" name="East-northeast"/>
<windSpeed mps="4.5" name="Gentle breeze"/>
<temperature unit="celsius" value="-4"/>
<pressure unit="hPa" value="1009.6"/>
</time>
<time from="2015-01-22T07:00:00" to="2015-01-22T13:00:00" period="1">
<!--
 Valid from 2015-01-22T07:00:00 to 2015-01-22T13:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-22T07:00:00  -->
<windDirection deg="62.1" code="ENE" name="East-northeast"/>
<windSpeed mps="3.7" name="Gentle breeze"/>
<temperature unit="celsius" value="-3"/>
<pressure unit="hPa" value="1010.8"/>
</time>
<time from="2015-01-22T13:00:00" to="2015-01-22T19:00:00" period="2">
<!--
 Valid from 2015-01-22T13:00:00 to 2015-01-22T19:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-22T13:00:00  -->
<windDirection deg="67.3" code="ENE" name="East-northeast"/>
<windSpeed mps="2.7" name="Light breeze"/>
<temperature unit="celsius" value="1"/>
<pressure unit="hPa" value="1012.7"/>
</time>
<time from="2015-01-22T19:00:00" to="2015-01-23T01:00:00" period="3">
<!--
 Valid from 2015-01-22T19:00:00 to 2015-01-23T01:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-22T19:00:00  -->
<windDirection deg="65.6" code="ENE" name="East-northeast"/>
<windSpeed mps="2.8" name="Light breeze"/>
<temperature unit="celsius" value="0"/>
<pressure unit="hPa" value="1014.7"/>
</time>
<time from="2015-01-23T01:00:00" to="2015-01-23T07:00:00" period="0">
<!--
 Valid from 2015-01-23T01:00:00 to 2015-01-23T07:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-23T01:00:00  -->
<windDirection deg="62.3" code="ENE" name="East-northeast"/>
<windSpeed mps="4.0" name="Gentle breeze"/>
<temperature unit="celsius" value="0"/>
<pressure unit="hPa" value="1015.7"/>
</time>
<time from="2015-01-23T07:00:00" to="2015-01-23T13:00:00" period="1">
<!--
 Valid from 2015-01-23T07:00:00 to 2015-01-23T13:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-23T07:00:00  -->
<windDirection deg="58.0" code="ENE" name="East-northeast"/>
<windSpeed mps="5.3" name="Gentle breeze"/>
<temperature unit="celsius" value="-1"/>
<pressure unit="hPa" value="1016.4"/>
</time>
<time from="2015-01-23T13:00:00" to="2015-01-23T19:00:00" period="2">
<!--
 Valid from 2015-01-23T13:00:00 to 2015-01-23T19:00:00 
-->
<symbol number="13" numberEx="49" name="Light snow" var="49"/>
<precipitation value="0.6"/>
<!--  Valid at 2015-01-23T13:00:00  -->
<windDirection deg="53.7" code="NE" name="Northeast"/>
<windSpeed mps="6.0" name="Moderate breeze"/>
<temperature unit="celsius" value="-1"/>
<pressure unit="hPa" value="1017.7"/>
</time>
<time from="2015-01-23T19:00:00" to="2015-01-24T01:00:00" period="3">
<!--
 Valid from 2015-01-23T19:00:00 to 2015-01-24T01:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0.4"/>
<!--  Valid at 2015-01-23T19:00:00  -->
<windDirection deg="57.4" code="ENE" name="East-northeast"/>
<windSpeed mps="5.5" name="Moderate breeze"/>
<temperature unit="celsius" value="-1"/>
<pressure unit="hPa" value="1019.0"/>
</time>
<time from="2015-01-24T01:00:00" to="2015-01-24T07:00:00" period="0">
<!--
 Valid from 2015-01-24T01:00:00 to 2015-01-24T07:00:00 
-->
<symbol number="13" numberEx="49" name="Light snow" var="49"/>
<precipitation value="0.9"/>
<!--  Valid at 2015-01-24T01:00:00  -->
<windDirection deg="62.6" code="ENE" name="East-northeast"/>
<windSpeed mps="4.9" name="Gentle breeze"/>
<temperature unit="celsius" value="-1"/>
<pressure unit="hPa" value="1021.6"/>
</time>
<time from="2015-01-24T07:00:00" to="2015-01-24T13:00:00" period="1">
<!--
 Valid from 2015-01-24T07:00:00 to 2015-01-24T13:00:00 
-->
<symbol number="13" numberEx="13" name="Snow" var="13"/>
<precipitation value="1.2"/>
<!--  Valid at 2015-01-24T07:00:00  -->
<windDirection deg="66.0" code="ENE" name="East-northeast"/>
<windSpeed mps="4.7" name="Gentle breeze"/>
<temperature unit="celsius" value="-2"/>
<pressure unit="hPa" value="1022.8"/>
</time>
<time from="2015-01-24T13:00:00" to="2015-01-24T19:00:00" period="2">
<!--
 Valid from 2015-01-24T13:00:00 to 2015-01-24T19:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0.2"/>
<!--  Valid at 2015-01-24T13:00:00  -->
<windDirection deg="72.1" code="ENE" name="East-northeast"/>
<windSpeed mps="4.5" name="Gentle breeze"/>
<temperature unit="celsius" value="-2"/>
<pressure unit="hPa" value="1025.9"/>
</time>
<time from="2015-01-24T19:00:00" to="2015-01-25T01:00:00" period="3">
<!--
 Valid from 2015-01-24T19:00:00 to 2015-01-25T01:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-24T19:00:00  -->
<windDirection deg="67.4" code="ENE" name="East-northeast"/>
<windSpeed mps="3.9" name="Gentle breeze"/>
<temperature unit="celsius" value="-6"/>
<pressure unit="hPa" value="1029.3"/>
</time>
</tabular>
</forecast>
</weatherdata>
XML;

public $xml2 = <<<XML
<weatherdata>
<location></location>
<credit></credit>
<links></links>
<meta></meta>
<sun rise="2015-01-15T08:18:23" set="2015-01-15T15:34:17"/>
<forecast>
<tabular>
<time from="2015-01-15T01:00:00" to="2015-01-15T06:00:00" period="0">
<!--
 Valid from 2015-01-15T01:00:00 to 2015-01-15T06:00:00 
-->
<symbol number="1" numberEx="1" name="Clear sky" var="mf/01n.83"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-15T01:00:00  -->
<windDirection deg="236.0" code="SW" name="Southwest"/>
<windSpeed mps="8.2" name="Fresh breeze"/>
<temperature unit="celsius" value="3"/>
<pressure unit="hPa" value="1002.6"/>
</time>
<time from="2015-01-15T06:00:00" to="2015-01-15T12:00:00" period="1">
<!--
 Valid from 2015-01-15T06:00:00 to 2015-01-15T12:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-15T06:00:00  -->
<windDirection deg="233.3" code="SW" name="Southwest"/>
<windSpeed mps="6.6" name="Moderate breeze"/>
<temperature unit="celsius" value="2"/>
<pressure unit="hPa" value="1006.1"/>
</time>
<time from="2015-01-15T12:00:00" to="2015-01-15T18:00:00" period="2">
<!--
 Valid from 2015-01-15T12:00:00 to 2015-01-15T18:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-15T12:00:00  -->
<windDirection deg="194.5" code="SSW" name="South-southwest"/>
<windSpeed mps="7.8" name="Moderate breeze"/>
<temperature unit="celsius" value="3"/>
<pressure unit="hPa" value="1005.8"/>
</time>
<time from="2015-01-15T18:00:00" to="2015-01-16T00:00:00" period="3">
<!--
 Valid from 2015-01-15T18:00:00 to 2015-01-16T00:00:00 
-->
<symbol number="9" numberEx="9" name="Rain" var="09"/>
<precipitation value="3.5" minvalue="3.0" maxvalue="4.0"/>
<!--  Valid at 2015-01-15T18:00:00  -->
<windDirection deg="172.7" code="S" name="South"/>
<windSpeed mps="8.3" name="Fresh breeze"/>
<temperature unit="celsius" value="3"/>
<pressure unit="hPa" value="1000.3"/>
</time>
<time from="2015-01-16T00:00:00" to="2015-01-16T06:00:00" period="0">
<!--
 Valid from 2015-01-16T00:00:00 to 2015-01-16T06:00:00 
-->
<symbol number="9" numberEx="9" name="Rain" var="09"/>
<precipitation value="3.0" minvalue="2.6" maxvalue="3.5"/>
<!--  Valid at 2015-01-16T00:00:00  -->
<windDirection deg="184.1" code="S" name="South"/>
<windSpeed mps="8.8" name="Fresh breeze"/>
<temperature unit="celsius" value="4"/>
<pressure unit="hPa" value="995.9"/>
</time>
<time from="2015-01-16T06:00:00" to="2015-01-16T12:00:00" period="1">
<!--
 Valid from 2015-01-16T06:00:00 to 2015-01-16T12:00:00 
-->
<symbol number="2" numberEx="2" name="Fair" var="02d"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-16T06:00:00  -->
<windDirection deg="212.3" code="SSW" name="South-southwest"/>
<windSpeed mps="9.4" name="Fresh breeze"/>
<temperature unit="celsius" value="5"/>
<pressure unit="hPa" value="994.1"/>
</time>
<time from="2015-01-16T12:00:00" to="2015-01-16T18:00:00" period="2">
<!--
 Valid from 2015-01-16T12:00:00 to 2015-01-16T18:00:00 
-->
<symbol number="1" numberEx="1" name="Clear sky" var="01d"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-16T12:00:00  -->
<windDirection deg="212.7" code="SSW" name="South-southwest"/>
<windSpeed mps="11.4" name="Strong breeze"/>
<temperature unit="celsius" value="5"/>
<pressure unit="hPa" value="996.4"/>
</time>
<time from="2015-01-16T18:00:00" to="2015-01-17T00:00:00" period="3">
<!--
 Valid from 2015-01-16T18:00:00 to 2015-01-17T00:00:00 
-->
<symbol number="3" numberEx="3" name="Partly cloudy" var="mf/03n.86"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-16T18:00:00  -->
<windDirection deg="222.9" code="SW" name="Southwest"/>
<windSpeed mps="9.4" name="Fresh breeze"/>
<temperature unit="celsius" value="4"/>
<pressure unit="hPa" value="1001.2"/>
</time>
<time from="2015-01-17T00:00:00" to="2015-01-17T06:00:00" period="0">
<!--
 Valid from 2015-01-17T00:00:00 to 2015-01-17T06:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-17T00:00:00  -->
<windDirection deg="215.5" code="SW" name="Southwest"/>
<windSpeed mps="5.9" name="Moderate breeze"/>
<temperature unit="celsius" value="3"/>
<pressure unit="hPa" value="1005.4"/>
</time>
<time from="2015-01-17T06:00:00" to="2015-01-17T12:00:00" period="1">
<!--
 Valid from 2015-01-17T06:00:00 to 2015-01-17T12:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-17T06:00:00  -->
<windDirection deg="202.7" code="SSW" name="South-southwest"/>
<windSpeed mps="2.5" name="Light breeze"/>
<temperature unit="celsius" value="2"/>
<pressure unit="hPa" value="1006.7"/>
</time>
<time from="2015-01-17T13:00:00" to="2015-01-17T19:00:00" period="2">
<!--
 Valid from 2015-01-17T13:00:00 to 2015-01-17T19:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-17T13:00:00  -->
<windDirection deg="254.7" code="WSW" name="West-southwest"/>
<windSpeed mps="2.7" name="Light breeze"/>
<temperature unit="celsius" value="3"/>
<pressure unit="hPa" value="1007.4"/>
</time>
<time from="2015-01-17T19:00:00" to="2015-01-18T01:00:00" period="3">
<!--
 Valid from 2015-01-17T19:00:00 to 2015-01-18T01:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-17T19:00:00  -->
<windDirection deg="271.9" code="W" name="West"/>
<windSpeed mps="2.4" name="Light breeze"/>
<temperature unit="celsius" value="2"/>
<pressure unit="hPa" value="1007.4"/>
</time>
<time from="2015-01-18T01:00:00" to="2015-01-18T07:00:00" period="0">
<!--
 Valid from 2015-01-18T01:00:00 to 2015-01-18T07:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-18T01:00:00  -->
<windDirection deg="247.8" code="WSW" name="West-southwest"/>
<windSpeed mps="2.0" name="Light breeze"/>
<temperature unit="celsius" value="1"/>
<pressure unit="hPa" value="1008.3"/>
</time>
<time from="2015-01-18T07:00:00" to="2015-01-18T13:00:00" period="1">
<!--
 Valid from 2015-01-18T07:00:00 to 2015-01-18T13:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0.4"/>
<!--  Valid at 2015-01-18T07:00:00  -->
<windDirection deg="207.3" code="SSW" name="South-southwest"/>
<windSpeed mps="1.1" name="Light air"/>
<temperature unit="celsius" value="1"/>
<pressure unit="hPa" value="1008.5"/>
</time>
<time from="2015-01-18T13:00:00" to="2015-01-18T19:00:00" period="2">
<!--
 Valid from 2015-01-18T13:00:00 to 2015-01-18T19:00:00 
-->
<symbol number="12" numberEx="12" name="Sleet" var="12"/>
<precipitation value="3.6"/>
<!--  Valid at 2015-01-18T13:00:00  -->
<windDirection deg="143.6" code="SE" name="Southeast"/>
<windSpeed mps="1.5" name="Light air"/>
<temperature unit="celsius" value="2"/>
<pressure unit="hPa" value="1008.5"/>
</time>
<time from="2015-01-18T19:00:00" to="2015-01-19T01:00:00" period="3">
<!--
 Valid from 2015-01-18T19:00:00 to 2015-01-19T01:00:00 
-->
<symbol number="8" numberEx="44" name="Light snow showers" var="mf/44n.93"/>
<precipitation value="0.9"/>
<!--  Valid at 2015-01-18T19:00:00  -->
<windDirection deg="17.8" code="NNE" name="North-northeast"/>
<windSpeed mps="2.8" name="Light breeze"/>
<temperature unit="celsius" value="1"/>
<pressure unit="hPa" value="1007.5"/>
</time>
<time from="2015-01-19T01:00:00" to="2015-01-19T07:00:00" period="0">
<!--
 Valid from 2015-01-19T01:00:00 to 2015-01-19T07:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0.2"/>
<!--  Valid at 2015-01-19T01:00:00  -->
<windDirection deg="324.7" code="NW" name="Northwest"/>
<windSpeed mps="4.8" name="Gentle breeze"/>
<temperature unit="celsius" value="0"/>
<pressure unit="hPa" value="1008.4"/>
</time>
<time from="2015-01-19T07:00:00" to="2015-01-19T13:00:00" period="1">
<!--
 Valid from 2015-01-19T07:00:00 to 2015-01-19T13:00:00 
-->
<symbol number="13" numberEx="49" name="Light snow" var="49"/>
<precipitation value="0.9"/>
<!--  Valid at 2015-01-19T07:00:00  -->
<windDirection deg="14.8" code="NNE" name="North-northeast"/>
<windSpeed mps="1.3" name="Light air"/>
<temperature unit="celsius" value="-1"/>
<pressure unit="hPa" value="1007.9"/>
</time>
<time from="2015-01-19T13:00:00" to="2015-01-19T19:00:00" period="2">
<!--
 Valid from 2015-01-19T13:00:00 to 2015-01-19T19:00:00 
-->
<symbol number="8" numberEx="8" name="Snow showers" var="08d"/>
<precipitation value="1.7"/>
<!--  Valid at 2015-01-19T13:00:00  -->
<windDirection deg="106.6" code="ESE" name="East-southeast"/>
<windSpeed mps="3.5" name="Gentle breeze"/>
<temperature unit="celsius" value="0"/>
<pressure unit="hPa" value="1007.2"/>
</time>
<time from="2015-01-19T19:00:00" to="2015-01-20T01:00:00" period="3">
<!--
 Valid from 2015-01-19T19:00:00 to 2015-01-20T01:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-19T19:00:00  -->
<windDirection deg="150.8" code="SSE" name="South-southeast"/>
<windSpeed mps="3.8" name="Gentle breeze"/>
<temperature unit="celsius" value="-1"/>
<pressure unit="hPa" value="1005.5"/>
</time>
<time from="2015-01-20T01:00:00" to="2015-01-20T07:00:00" period="0">
<!--
 Valid from 2015-01-20T01:00:00 to 2015-01-20T07:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0.3"/>
<!--  Valid at 2015-01-20T01:00:00  -->
<windDirection deg="153.7" code="SSE" name="South-southeast"/>
<windSpeed mps="4.3" name="Gentle breeze"/>
<temperature unit="celsius" value="-1"/>
<pressure unit="hPa" value="1004.9"/>
</time>
<time from="2015-01-20T07:00:00" to="2015-01-20T13:00:00" period="1">
<!--
 Valid from 2015-01-20T07:00:00 to 2015-01-20T13:00:00 
-->
<symbol number="13" numberEx="13" name="Snow" var="13"/>
<precipitation value="2.0"/>
<!--  Valid at 2015-01-20T07:00:00  -->
<windDirection deg="131.1" code="SE" name="Southeast"/>
<windSpeed mps="2.8" name="Light breeze"/>
<temperature unit="celsius" value="-1"/>
<pressure unit="hPa" value="1002.9"/>
</time>
<time from="2015-01-20T13:00:00" to="2015-01-20T19:00:00" period="2">
<!--
 Valid from 2015-01-20T13:00:00 to 2015-01-20T19:00:00 
-->
<symbol number="13" numberEx="13" name="Snow" var="13"/>
<precipitation value="1.5"/>
<!--  Valid at 2015-01-20T13:00:00  -->
<windDirection deg="351.3" code="N" name="North"/>
<windSpeed mps="0.6" name="Light air"/>
<temperature unit="celsius" value="1"/>
<pressure unit="hPa" value="1001.4"/>
</time>
<time from="2015-01-20T19:00:00" to="2015-01-21T01:00:00" period="3">
<!--
 Valid from 2015-01-20T19:00:00 to 2015-01-21T01:00:00 
-->
<symbol number="8" numberEx="8" name="Snow showers" var="mf/08n.00"/>
<precipitation value="1.2"/>
<!--  Valid at 2015-01-20T19:00:00  -->
<windDirection deg="296.4" code="WNW" name="West-northwest"/>
<windSpeed mps="3.7" name="Gentle breeze"/>
<temperature unit="celsius" value="0"/>
<pressure unit="hPa" value="1000.7"/>
</time>
<time from="2015-01-21T01:00:00" to="2015-01-21T07:00:00" period="0">
<!--
 Valid from 2015-01-21T01:00:00 to 2015-01-21T07:00:00 
-->
<symbol number="8" numberEx="44" name="Light snow showers" var="mf/44n.03"/>
<precipitation value="0.5"/>
<!--  Valid at 2015-01-21T01:00:00  -->
<windDirection deg="342.6" code="NNW" name="North-northwest"/>
<windSpeed mps="4.9" name="Gentle breeze"/>
<temperature unit="celsius" value="0"/>
<pressure unit="hPa" value="1003.5"/>
</time>
<time from="2015-01-21T07:00:00" to="2015-01-21T13:00:00" period="1">
<!--
 Valid from 2015-01-21T07:00:00 to 2015-01-21T13:00:00 
-->
<symbol number="13" numberEx="49" name="Light snow" var="49"/>
<precipitation value="0.6"/>
<!--  Valid at 2015-01-21T07:00:00  -->
<windDirection deg="16.4" code="NNE" name="North-northeast"/>
<windSpeed mps="5.4" name="Gentle breeze"/>
<temperature unit="celsius" value="-1"/>
<pressure unit="hPa" value="1005.8"/>
</time>
<time from="2015-01-21T13:00:00" to="2015-01-21T19:00:00" period="2">
<!--
 Valid from 2015-01-21T13:00:00 to 2015-01-21T19:00:00 
-->
<symbol number="3" numberEx="3" name="Partly cloudy" var="03d"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-21T13:00:00  -->
<windDirection deg="27.0" code="NNE" name="North-northeast"/>
<windSpeed mps="4.8" name="Gentle breeze"/>
<temperature unit="celsius" value="0"/>
<pressure unit="hPa" value="1009.1"/>
</time>
<time from="2015-01-21T19:00:00" to="2015-01-22T01:00:00" period="3">
<!--
 Valid from 2015-01-21T19:00:00 to 2015-01-22T01:00:00 
-->
<symbol number="3" numberEx="3" name="Partly cloudy" var="mf/03n.03"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-21T19:00:00  -->
<windDirection deg="51.9" code="NE" name="Northeast"/>
<windSpeed mps="4.3" name="Gentle breeze"/>
<temperature unit="celsius" value="-2"/>
<pressure unit="hPa" value="1010.9"/>
</time>
<time from="2015-01-22T01:00:00" to="2015-01-22T07:00:00" period="0">
<!--
 Valid from 2015-01-22T01:00:00 to 2015-01-22T07:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-22T01:00:00  -->
<windDirection deg="52.6" code="NE" name="Northeast"/>
<windSpeed mps="5.0" name="Gentle breeze"/>
<temperature unit="celsius" value="-2"/>
<pressure unit="hPa" value="1012.4"/>
</time>
<time from="2015-01-22T07:00:00" to="2015-01-22T13:00:00" period="1">
<!--
 Valid from 2015-01-22T07:00:00 to 2015-01-22T13:00:00 
-->
<symbol number="2" numberEx="2" name="Fair" var="02d"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-22T07:00:00  -->
<windDirection deg="62.3" code="ENE" name="East-northeast"/>
<windSpeed mps="5.3" name="Gentle breeze"/>
<temperature unit="celsius" value="-2"/>
<pressure unit="hPa" value="1013.3"/>
</time>
<time from="2015-01-22T13:00:00" to="2015-01-22T19:00:00" period="2">
<!--
 Valid from 2015-01-22T13:00:00 to 2015-01-22T19:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-22T13:00:00  -->
<windDirection deg="63.6" code="ENE" name="East-northeast"/>
<windSpeed mps="7.2" name="Moderate breeze"/>
<temperature unit="celsius" value="0"/>
<pressure unit="hPa" value="1014.2"/>
</time>
<time from="2015-01-22T19:00:00" to="2015-01-23T01:00:00" period="3">
<!--
 Valid from 2015-01-22T19:00:00 to 2015-01-23T01:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0"/>
<!--  Valid at 2015-01-22T19:00:00  -->
<windDirection deg="69.3" code="ENE" name="East-northeast"/>
<windSpeed mps="9.4" name="Fresh breeze"/>
<temperature unit="celsius" value="-1"/>
<pressure unit="hPa" value="1015.5"/>
</time>
<time from="2015-01-23T01:00:00" to="2015-01-23T07:00:00" period="0">
<!--
 Valid from 2015-01-23T01:00:00 to 2015-01-23T07:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0.2"/>
<!--  Valid at 2015-01-23T01:00:00  -->
<windDirection deg="69.0" code="ENE" name="East-northeast"/>
<windSpeed mps="11.3" name="Strong breeze"/>
<temperature unit="celsius" value="-1"/>
<pressure unit="hPa" value="1017.4"/>
</time>
<time from="2015-01-23T07:00:00" to="2015-01-23T13:00:00" period="1">
<!--
 Valid from 2015-01-23T07:00:00 to 2015-01-23T13:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0.3"/>
<!--  Valid at 2015-01-23T07:00:00  -->
<windDirection deg="72.1" code="ENE" name="East-northeast"/>
<windSpeed mps="11.8" name="Strong breeze"/>
<temperature unit="celsius" value="0"/>
<pressure unit="hPa" value="1018.7"/>
</time>
<time from="2015-01-23T13:00:00" to="2015-01-23T19:00:00" period="2">
<!--
 Valid from 2015-01-23T13:00:00 to 2015-01-23T19:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0.3"/>
<!--  Valid at 2015-01-23T13:00:00  -->
<windDirection deg="76.3" code="ENE" name="East-northeast"/>
<windSpeed mps="11.2" name="Strong breeze"/>
<temperature unit="celsius" value="0"/>
<pressure unit="hPa" value="1020.7"/>
</time>
<time from="2015-01-23T19:00:00" to="2015-01-24T01:00:00" period="3">
<!--
 Valid from 2015-01-23T19:00:00 to 2015-01-24T01:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0.3"/>
<!--  Valid at 2015-01-23T19:00:00  -->
<windDirection deg="78.1" code="ENE" name="East-northeast"/>
<windSpeed mps="10.7" name="Fresh breeze"/>
<temperature unit="celsius" value="-1"/>
<pressure unit="hPa" value="1021.9"/>
</time>
<time from="2015-01-24T01:00:00" to="2015-01-24T07:00:00" period="0">
<!--
 Valid from 2015-01-24T01:00:00 to 2015-01-24T07:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0.3"/>
<!--  Valid at 2015-01-24T01:00:00  -->
<windDirection deg="78.0" code="ENE" name="East-northeast"/>
<windSpeed mps="9.3" name="Fresh breeze"/>
<temperature unit="celsius" value="-2"/>
<pressure unit="hPa" value="1022.4"/>
</time>
<time from="2015-01-24T07:00:00" to="2015-01-24T13:00:00" period="1">
<!--
 Valid from 2015-01-24T07:00:00 to 2015-01-24T13:00:00 
-->
<symbol number="4" numberEx="4" name="Cloudy" var="04"/>
<precipitation value="0.4"/>
<!--  Valid at 2015-01-24T07:00:00  -->
<windDirection deg="70.7" code="ENE" name="East-northeast"/>
<windSpeed mps="8.5" name="Fresh breeze"/>
<temperature unit="celsius" value="-3"/>
<pressure unit="hPa" value="1021.5"/>
</time>
</tabular>
</forecast>
</weatherdata>
XML;

}
