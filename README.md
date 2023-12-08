# 64chan
**Teknisk Dokumentasjon: Webforum Plattform**
**1. Systemarkitektur:**
1.1 **Backend:**
- **Programvare:** PHP (v7.4.3)
- **Database:** MySQL (v8.0.23)
- **Servermiljø:** Apache (v2.4.41)
1.2 **Frontend:**
- **Språk:** HTML5, CSS3, JavaScript (ES6)
- **Biblioteker:** Bootstrap (v4.6.0), jQuery (v3.5.1)
**2. Databasestruktur:**
2.1 **Brukerdatabase:**
- **bruker:**
 - idbruker (Primærnøkkel, INT)
 - brukernavn (UNIK, VARCHAR)
 - passord (VARCHAR)
 - email (UNIK, VARCHAR)
2.2 **Tråddatabase:**
- **threads:**
 - idthread (Primærnøkkel, INT)
 - idbruker (FOREIGN KEY, INT)
 - tittel (VARCHAR)
 - timestamp (DATETIME)
 - innhold (VARCHAR)
2.3 **Innleggsdatabase:**
- **posts:**
 - idpost (Primærnøkkel, INT)
 - idthread (FOREIGN KEY, INT)
 - idbruker (FOREIGN KEY, INT)
 - timestamp (DATETIME)
 - innhold (VARCHAR)
2.4 **Svardatabase:**
- **replies:**
 - idreply (Primærnøkkel, INT)
 - idthread (FOREIGN KEY, INT)
 - idbruker (FOREIGN KEY, INT)
 - timestamp (DATETIME)
 - innhold (VARCHAR)
**3. Sikkerhet:**
3.1 **HTTPS-implementering:**
- Sikret datatransmisjon for beskyttelse mot avlytting.
3.2 **SQL-Injeksjonsforebygging:**
- Bruk av forberedte uttalelser for å unngå SQL-injeksjoner.
3.3 **Brukerpålogging:**
- Sikker håndtering av brukerinformasjon med passordhashing.
**4. Oppsett og Installasjon:**
4.1 **Serverkonfigurasjon:**
- Apache- og PHP-konfigurasjonsjustering for optimal ytelse.
4.2 **Databaseinstallasjon:**
- Opprettelse av MySQL-database og brukerrettigheter.
4.3 **Kodeimplementering:**
- Nedlasting og opplasting av kildematerialet.
- Konfigurering av tilkoblingsparametere.
**5. Feilsøking og Vedlikehold:**
5.1 **Loggføring:**
- Implementering av loggsystem for feilsøking og overvåking.
5.2 **Oppdateringer og Sikkerhetspatcher:**
- Periodisk vedlikehold for å håndtere sikkerhetsoppdateringer.
Dette dokumentet gir en grundig oversikt over webforumets tekniske aspekter, inkludert systemkomponenter, databasestruktur, sikkerhet og vedlikeholdsrutiner. For ytterligere assistanse, se detaljerte instruksjoner i tilknyttede moduler.
