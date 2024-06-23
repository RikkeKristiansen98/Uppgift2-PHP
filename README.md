
.env 
domain_mailgun=""
api_key=""



Bygg en SaaS-tjänst för att kunder ska kunna hantera sina epost-listor. Vi kommer ha 2 roller av användare, kunder och prenumeranter, där en kund kan se en lista med uppgifter prenumeranter som har valt att prenumerera på deras nyhetsbrev.

 Databasen ska vara MySQL (eller Mariadb).

- Alla sidor ska vara skrivna i php (ingen react mot api tillåten för denna uppgift).
- Ett användarkonto ska lagra namn (för- och efternamn), epostadress och hash för lösenord.
- Ett kundkonto ska ha information om nyhetsbrevet: namn och beskrivning
- En prenumerant ska enkelt kunna börja prenumerera och sluta prenumerera på ett nyhetsbrev
- Fungerande inloggning och återställning av lösenord, med epostutskick.
- Epost ska skickas med en Email service provider (ESP)
- Dessa sidor ska finnas:
-- Skapa konto (välj typ: kund eller prenumerant)
-- Lista alla nyhetsbrev
--- Enskilt nyhetsbrev (prenumerera / avregistrera)
-- Logga in
--- Återställ lösenord
---- Ange nytt lösenord
--- Utloggad (Endast: meddelande om att man är utloggad)
-- Mina sidor (Endast: välkomstmeddelande efter inloggning)
--- Mina prenumerationer (för prenumeranter)
--- Mina prenumeranter (för kunder)
--- Mitt nyhetsbrev / Redigera nyhetsbrev (för kunder)
 
- Menyn på sidan ska vara annorlunda baserat på om du är kund eller prenumerant
-- Meny för utloggad: Alla nyhetsbrev, Logga in, Skapa konto
-- Meny för prenumerant: Alla nyhetsbrev, Mina prenumerationer, Logga ut
-- Meny för kunder:  Mina prenumeranter, Mitt nyhetsbrev, Logga ut

 - Om man försöker visa en sida som man inte har tillgång till (baserat på användarroll) ska det visas ett meddelande om att man inte får det. Alternativt göra en redirect till en sida med samma information

