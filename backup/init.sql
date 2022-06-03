CREATE DATABASE WordlAR
GO
USE WordlAR
GO
--CREAMOS TABLA DE PALABRAS
CREATE TABLE Words (
    ID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    Word VARCHAR(5) NOT NULL UNIQUE,
    Published DATE NOT NULL UNIQUE
)
--CREAMOS TABLA DE USUARIOS
CREATE TABLE Users (
    ID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    Name VARCHAR(100) NULL,
    Username VARCHAR(100) NOT NULL UNIQUE,
    Email VARCHAR(250) NULL,
    Pswd VARCHAR(100) NULL,
    Disabled BIT NULL Default 0
)
--CREAMOS TABLA DE RESULTADOS
CREATE TABLE RESULTS (
    IDUser INT NOT NULL,
    IDWord INT NOT NULL,
    TriedWord VARCHAR(5) NOT NULL,
    Resultado VARCHAR(5) NOT NULL,
    --CorrectWord BIT DEFAULT 0,
    CONSTRAINT fkUser FOREIGN KEY (IDUser) REFERENCES Users(ID),
    CONSTRAINT fkWord FOREIGN KEY (IDWord) REFERENCES Words(ID)
)

--AÑADIMOS FUNCIÓN QUE NOS DEVUELVE EL RESULTADO
GO
CREATE OR ALTER FUNCTION dbo.CheckWord(@word as VARCHAR(5))
    RETURNS VARCHAR(5)
AS
    BEGIN
        DECLARE @todayWord AS VARCHAR(5) = (SELECT Word FROM Words WHERE Published = CONCAT(YEAR(GETDATE()),'-',MONTH(GETDATE()),'-',DAY(GETDATE())))
        DECLARE @result VARCHAR(5) =
        CONCAT(
            CASE
                WHEN CHARINDEX(SUBSTRING(@word, 1, 1), SUBSTRING(@todayWord, 1, 1)) = 1 THEN 2
                WHEN CHARINDEX(SUBSTRING(@word, 1, 1), @todayWord) = 0 THEN 0
                ELSE 1
                END,
            CASE
                WHEN CHARINDEX(SUBSTRING(@word, 2, 1), SUBSTRING(@todayWord, 2, 1)) = 1 THEN 2
                WHEN CHARINDEX(SUBSTRING(@word, 2, 1), @todayWord) = 0 THEN 0
                ELSE 1
                END,
            CASE
                WHEN CHARINDEX(SUBSTRING(@word, 3, 1), SUBSTRING(@todayWord, 3, 1)) = 1 THEN 2
                WHEN CHARINDEX(SUBSTRING(@word, 3, 1), @todayWord) = 0 THEN 0
                ELSE 1
                END,
            CASE
                WHEN CHARINDEX(SUBSTRING(@word, 4, 1), SUBSTRING(@todayWord, 4, 1)) = 1 THEN 2
                WHEN CHARINDEX(SUBSTRING(@word, 4, 1), @todayWord) = 0 THEN 0
                ELSE 1
                END,
            CASE
                WHEN CHARINDEX(SUBSTRING(@word, 5, 1), SUBSTRING(@todayWord, 5, 1)) = 1 THEN 2
                WHEN CHARINDEX(SUBSTRING(@word, 5, 1), @todayWord) = 0 THEN 0
                ELSE 1                
                END
        )
        RETURN @result
    END
GO

--INSERTAMOS PALABRAS
CREATE TABLE dbo.TempWords
( 
    word VARCHAR(5)
);

BULK INSERT TempWords FROM '/var/opt/mssql/data/SpanishWords.txt'
WITH (
ROWTERMINATOR = '0x0a')

--PROCEDURE PARA JUGAR
GO
CREATE OR ALTER PROCEDURE Jugar
  @jugador as varchar(100),
  @palabraIntentada as varchar(5),
  @result as VARCHAR(5) OUTPUT
AS
BEGIN
IF ((SELECT COUNT(1) FROM Users WHERE UserName = @jugador) = 0)
    BEGIN
        INSERT INTO Users (Username) VALUES (@jugador);
    END
    DECLARE @intentos AS INT = (select count(1) from results r inner join users u on u.id=r.IDUser inner join words w on w.ID = r.IDWord where u.Name= @jugador and w.Published = cast(getdate() as date))
    PRINT CONCAT('NUMERO DE INTENTOS :',@INtentos)
    IF ((@intentos < 6) AND (SELECT COUNT(1) FROM Users WHERE UserName = @jugador) > 0 )
        BEGIN
            SET @result = dbo.CheckWord(@palabraIntentada)
            INSERT INTO Results (IDUser,IDWord,TriedWord,Resultado) VALUES ((SELECT ID FROM Users WHERE UserName = @jugador),(SELECT ID FROM Words WHERE Published = CONCAT(YEAR(GETDATE()),'-',MONTH(GETDATE()),'-',DAY(GETDATE()))),@palabraIntentada,@result)
        END
    ELSE
    BEGIN
        SET @result = 'FINAL'
    END
    PRINT @RESULT
END
GO

select * from words

INSERT INTO Words(Word,Published) VALUES ('pakas',cast(GETDATE() as date))
INSERT INTO Words(Word,Published) VALUES ('chute',DATEADD(DAY,1,cast(GETDATE() as date)))
INSERT INTO Words(Word,Published) VALUES ('crack',DATEADD(DAY,2,cast(GETDATE() as date)))
INSERT INTO Words(Word,Published) VALUES ('polvo',DATEADD(DAY,3,cast(GETDATE() as date)))
INSERT INTO Words(Word,Published) VALUES ('tripi',DATEADD(DAY,4,cast(GETDATE() as date)))
INSERT INTO Words(Word,Published) VALUES ('speed',DATEADD(DAY,5,cast(GETDATE() as date)))
INSERT INTO Words(Word,Published) VALUES ('droga',DATEADD(DAY,6,cast(GETDATE() as date)))
INSERT INTO Words(Word,Published) VALUES ('maria',DATEADD(DAY,7,cast(GETDATE() as date)))
INSERT INTO Words(Word,Published) VALUES ('dopar',DATEADD(DAY,8,cast(GETDATE() as date)))
INSERT INTO Words(Word,Published) VALUES ('Comna',DATEADD(DAY,9,cast(GETDATE() as date)))
INSERT INTO Words(Word,Published) VALUES ('narco',DATEADD(DAY,10,cast(GETDATE() as date)))
INSERT INTO Words(Word,Published) VALUES ('fardo',DATEADD(DAY,11,cast(GETDATE() as date)))
INSERT INTO Words(Word,Published) VALUES ('kilos',DATEADD(DAY,12,cast(GETDATE() as date)))
INSERT INTO Words(Word,Published) VALUES ('porro',DATEADD(DAY,13,cast(GETDATE() as date)))
INSERT INTO Words(Word,Published) VALUES ('capos',DATEADD(DAY,14,cast(GETDATE() as date)))
INSERT INTO Words(Word,Published) VALUES ('polen',DATEADD(DAY,15,cast(GETDATE() as date)))
INSERT INTO Words(Word,Published) VALUES ('chino',DATEADD(DAY,16,cast(GETDATE() as date)))


--exec Jugar 'martagonsito','PUTTA',''

SELECT Word FROM WORDS WHERE Published=cast(getdate() as date)

select substring(TriedWord,1,1) as pal1, substring(TriedWord,2,1) as pal2, substring(TriedWord,3,1) as pal3, substring(TriedWord,4,1) as pal4, substring(TriedWord,5,1) as pal5, substring(Resultado,1,1) as res1, substring(Resultado,2,1) as res2, substring(Resultado,3,1) as res3, substring(Resultado,4,1) as res4, substring(Resultado,5,1) as res5 from results r inner join users j on j.id=r.IDUser inner join words p on r.IDWord=p.id where j.username = 'phgasif9mmtcati17770i2o7p2' and Published = cast(getdate() as date)