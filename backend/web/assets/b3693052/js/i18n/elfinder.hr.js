/*
 * Croatian translation
 * @author FULEREN d.o.o.
 * @version 2012-02-01
 */
(function($) {
if (elFinder && elFinder.prototype.options && elFinder.prototype.options.i18n) 
	elFinder.prototype.options.i18n.hr = {
		/* errors */
		'Root directory does not exists'       : 'Ne postoji korijenska mapa',
		'Unable to connect to backend'         : 'Spajanje na pozadinski modul nije moguć',
		'Access denied'                        : 'Odbijen pristup',
		'Invalid backend configuration'        : 'Neispravne postavke pozadinskog modula',
		'Unknown command'                      : 'Nepoznata naredba',
		'Command not allowed'                  : 'Nedozvoljena naredba',
		'Invalid parameters'                   : 'Neispravni parametri',
		'File not found'                       : 'Datoteka nije nađena',
		'Invalid name'                         : 'Neispravan naziv',
		'File or folder with the same name already exists' : 'Već postoji datoteka ili mapa istog naziva',
		'Unable to rename file'                : 'Nije moguće izmijeniti naziv datoteke',
		'Unable to create folder'              : 'Nije moguće načiniti mapu',
		'Unable to create file'                : 'Nije moguće načiniti datoteku',  
		'No file to upload'                    : 'Nema datoteke za postavljanje',
		'Select at least one file to upload'   : 'Odaberite barem jednu datoteku za postavljanje',
		'File exceeds the maximum allowed filesize' : 'Datoteka premašuje najveću dopuštenu veličinu',
		'Not allowed file type'                 : 'Nedozvoljena vrsta datoteke',
		'Unable to upload file'                 : 'Nije moguće postaviti datoteku',
		'Unable to upload files'                : 'Nije moguće postaviti datoteke',
		'Unable to remove file'                 : 'Nije moguće ukloniti datoteku',
		'Unable to save uploaded file'          : 'Nije moguće pohraniti postavljenu datoteku',
		'Some files was not uploaded'           : 'Neke datoteke nisu postavljene',
		'Unable to copy into itself'            : 'Nije moguće kopirati na isto mjesto',
		'Unable to move files'                  : 'Nije moguće premjestiti datoteke',
		'Unable to copy files'                  : 'Nije moguće kopirati datoteke',
		'Unable to create file copy'            : 'Nije moguće načiniti kopiju datoteke',
		'File is not an image'                  : 'Datoteka nije slika',
		'Unable to resize image'                : 'Nije moguće promijeniti dimenzije slike',
		'Unable to write to file'               : 'Nije moguće pisati u datoteku',
		'Unable to create archive'              : 'Nije moguće načiniti arhivu',
		'Unable to extract files from archive'  : 'Nije moguće izdvojiti datoteke iz arhive',
		'Unable to open broken link'            : 'Nije moguće otvoriti neispravnu poveznicu',
		'File URL disabled by connector config' : 'Putanja datoteke onemogućena u postavkama poveznika',
		/* statusbar */
		'items'          : 'stavke',
		'selected items' : 'odabrane stavke',
		/* commands/buttons */
		'Back'                    : 'Natrag',
		'Reload'                  : 'Osvježi',
		'Open'                    : 'Otvori',
		'Preview with Quick Look' : 'Pregled u brzom pregledniku',
		'Select file'             : 'Odaberi datoteku',
		'New folder'              : 'Nova mapa',
		'New text file'           : 'Nova tekstualna datoteka',
		'Upload files'            : 'Postavi datoteke',
		'Copy'                    : 'Kopiraj',
		'Cut'                     : 'Izreži',
		'Paste'                   : 'Zalijepi',
		'Duplicate'               : 'Udvostruči',
		'Remove'                  : 'Ukloni',
		'Rename'                  : 'Preimenuj',
		'Edit text file'          : 'Uredi tekstualnu datoteku',
		'View as icons'           : 'Pregled sa sličicama',
		'View as list'            : 'Pregled s popisom',
		'Resize image'            : 'Promjeni dimenzije slike',
		'Create archive'          : 'Načini arhivu',
		'Uncompress archive'      : 'Izdvoji arhivu',
		'Get info'                : 'Informacije',
		'Help'                    : 'Pomoć',
		'Dock/undock filemanager window' : 'Uključi/isključi prikaz upravitelja datoteka u zasebnom prozoru',
		/* upload/get info dialogs */
		'Maximum allowed files size' : 'Najveća dopuštena veličina datoteka',
		'Add field'   : 'Dodaj polje',
		'File info'   : 'Informacije o datoteci',
		'Folder info' : 'Informacije o mapi',
		'Name'        : 'Naziv',
		'Kind'        : 'Vrsta',
		'Size'        : 'Veličina',
		'Modified'    : 'Izmjenjeno',
		'Permissions' : 'Dozvole',
		'Link to'     : 'Poveznica',
		'Dimensions'  : 'Dimenzije',
		'Confirmation required' : 'Potrebna potvrda',
		'Are you sure you want to remove files?<br /> This cannot be undone!' : 'Jeste li sigurni da želite ukloniti datoteke?<br /> Ovo se ne može povratiti!',
		/* permissions */
		'read'        : 'čitanje',
		'write'       : 'pisanje',
		'remove'      : 'brisanje',
		/* dates */
		'Jan'         : 'Sij',
		'Feb'         : 'Velj',
		'Mar'         : 'Ožu',
		'Apr'         : 'Tra',
		'May'         : 'Svi',
		'Jun'         : 'Lip',
		'Jul'         : 'Srp',
		'Aug'         : 'Kol',
		'Sep'         : 'Ruj',
		'Oct'         : 'Lis',
		'Nov'         : 'Stu',
		'Dec'         : 'Pro',
		'Today'       : 'Danas',
		'Yesterday'   : 'Jučer',
		/* mimetypes */
		'Unknown'                           : 'Nepoznato',
		'Folder'                            : 'Mapa',
		'Alias'                             : 'Zamjenica',
		'Broken alias'                      : 'Neispravna zamjenica',
		'Plain text'                        : 'Običan tekst',
		'Postscript document'               : 'Postscript dokument',
		'Application'                       : 'Aplikacija',
		'Microsoft Office document'         : 'MS Office dokument',
		'Microsoft Word document'           : 'MS Word dokument',  
		'Microsoft Excel document'          : 'MS Excel dokument',
		'Microsoft Powerpoint presentation' : 'MS Powepoint dokument',
		'Open Office document'              : 'Open Office dokument',
		'Flash application'                 : 'Flash aplikacija',
		'XML document'                      : 'XML dokument',
		'Bittorrent file'                   : 'Torrent datoteka',
		'7z archive'                        : '7z arhiva',
		'TAR archive'                       : 'TAR arhiva',
		'GZIP archive'                      : 'GZIP arhiva',
		'BZIP archive'                      : 'BZIP arhiva',
		'ZIP archive'                       : 'ZIP arhiva',
		'RAR archive'                       : 'RAR arhiva',
		'Javascript application'            : 'Javascript aplikacija',
		'PHP source'                        : 'PHP kod',
		'HTML document'                     : 'HTML dokument',
		'Javascript source'                 : 'Javascript kod',
		'CSS style sheet'                   : 'CSS datoteka stilova',
		'C source'                          : 'C kod',
		'C++ source'                        : 'C++ kod',
		'Unix shell script'                 : 'Skripta Unix ljuske',
		'Python source'                     : 'Python kod',
		'Java source'                       : 'Java kod',
		'Ruby source'                       : 'Ruby kod',
		'Perl script'                       : 'Perl skripta',
		'BMP image'                         : 'BMP slika',
		'JPEG image'                        : 'JPEG slika',
		'GIF Image'                         : 'GIF slika',
		'PNG Image'                         : 'PNG slika',
		'TIFF image'                        : 'TIFF slika',
		'TGA image'                         : 'TGA slika',
		'Adobe Photoshop image'             : 'Adobe Photoshop slika',
		'MPEG audio'                        : 'MPEG zvučni zapis',
		'MIDI audio'                        : 'MIDI zvučni zapis',
		'Ogg Vorbis audio'                  : 'Ogg Vorbis zvučni zapis',
		'MP4 audio'                         : 'MP4 zvučni zapis',
		'WAV audio'                         : 'WAV zvučni zapis',
		'DV video'                          : 'DV video zapis',
		'MP4 video'                         : 'MP4 video zapis',
		'MPEG video'                        : 'MPEG video zapis',
		'AVI video'                         : 'AVI video zapis',
		'Quicktime video'                   : 'Quicktime video zapis',
		'WM video'                          : 'WM video zapis',
		'Flash video'                       : 'Flash video zapis',
		'Matroska video'                    : 'Matroska video zapis',
		// 'Shortcuts' : 'Prečaci',		
		'Select all files' : 'Odaberi sve datoteke',
		'Copy/Cut/Paste files' : 'Kopiraj/Izreži/Zalijepi datoteke',
		'Open selected file/folder' : 'Otvori odabranu datoteku/mapu',
		'Open/close QuickLook window' : 'Otvori/zatvori prozor brzog pregleda',
		'Remove selected files' : 'Ukloni odabrane datoteke',
		'Selected files or current directory info' : 'Podaci o odabranim datotekama ili mapi',
		'Create new directory' : 'Načini novu mapu',
		'Open upload files form' : 'Otvori obrazac za postavljanje datoteka',
		'Select previous file' : 'Odaberi prethodnu datoteku',
		'Select next file' : 'Odaberi sljedeću datoteku',
		'Return into previous folder' : 'Povratak u prethodnu mapu',
		'Increase/decrease files selection' : 'Povećaj/smanji opseg odabira datoteka',
		'Authors'                       : 'Tvorci',
		'Sponsors'  : 'Pokrovitelji',
		'elFinder: Web file manager'    : 'elFinder: Web upravitelj datoteka',
		'Version'                       : 'Inačica',
		'Copyright: Studio 42 LTD'      : 'Autorska prava: Studio 42 LTD',
		'Donate to support project development' : 'Donacijom podržite razvoj projekta',
		'Javascripts/PHP programming: Dmitry (dio) Levashov, dio@std42.ru' : 'Javascript/PHP programiranje: Dmitry (dio) Levashov, dio@std42.ru',
		'Python programming, techsupport: Troex Nevelin, troex@fury.scancode.ru' : 'Python programiranje, tehnička podrška: Troex Nevelin, troex@fury.scancode.ru',
		'Design: Valentin Razumnih'     : 'Grafičko oblikovanje: Valentin Razumnih',
		'Spanish localization'          : 'Lokalizacija na španjolski',
		'Icons' : 'Ikone',
		'License: BSD License'          : 'Licenca: BSD Licenca',
		'elFinder documentation'        : 'elFinder dokumentacija',
		'Simple and usefull Content Management System' : 'Jednostavan i koristan sustav za upravljanje sadržajem',
		'Support project development and we will place here info about you' : 'Ako podržite razvoj projekta, Vaše ćemo podatke prikazati ovdje',
		'Contacts us if you need help integrating elFinder in you products' : 'Kontaktirajte nas ako trebate pomoć pri ugradnji elFindera u Vaše proizvode/usluge',
		'helpText' : 'elFinder funkcionira slično upravitelju datotekama na Vašem računalu<br />Da biste izveli radnje nad datotekama/mapama koristite se ikonama u gornjoj traci. Ako niste sigurni čemu služi pojedini alat, postavite pokazivač iznad alata da biste vidjeli uputu.<br />Upravljanje postojećim datotekama/mapama možete vršiti u putem kontekstnog izbornika (desni klik mišem).<br />Za kopiranje/brisanje većeg broja datoteka, odaberite ih koristeći se tipkama Shift/Alt + lijevi klik mišem.'

	};
	
})(jQuery);
