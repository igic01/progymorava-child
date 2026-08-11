<?php
/**
 * Small builder for local ACF field-group definitions.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Builds consistently keyed ACF tabs and fields for a single field group.
 */
class Progymorava_Child_Acf_Field_Builder {
	/**
	 * Field-key prefix for the current group.
	 *
	 * @var string
	 */
	private $prefix;

	/**
	 * Registered field definitions.
	 *
	 * @var array<int,array<string,mixed>>
	 */
	private $items = array();

	/**
	 * Create a builder for one ACF field-group key prefix.
	 *
	 * @param string $prefix Prefix used for each ACF field key.
	 */
	public function __construct( $prefix ) {
		$this->prefix = (string) $prefix;
	}

	/**
	 * Add a top-placed ACF tab.
	 *
	 * @param string $key   Field-key suffix.
	 * @param string $label Tab label.
	 * @return self
	 */
	public function tab( $key, $label ) {
		$this->items[] = array(
			'key'       => $this->prefix . $key,
			'label'     => self::slovak_label( $label ),
			'name'      => '',
			'type'      => 'tab',
			'placement' => 'top',
		);

		return $this;
	}

	/**
	 * Backward-compatible alias for tab().
	 *
	 * @param string $key   Field-key suffix.
	 * @param string $label Tab label.
	 * @return self
	 */
	public function add_tab( $key, $label ) {
		return $this->tab( $key, $label );
	}

	/**
	 * Add an ACF field.
	 *
	 * @param string              $key      Field-key suffix.
	 * @param string              $label    Field label.
	 * @param string              $name     Field name.
	 * @param string              $type     ACF field type.
	 * @param mixed               $default  Optional default value.
	 * @param array<string,mixed> $settings Additional ACF field settings.
	 * @return self
	 */
	public function field( $key, $label, $name, $type = 'text', $default = null, $settings = array() ) {
		$field = array(
			'key'   => $this->prefix . $key,
			'label' => self::slovak_label( $label ),
			'name'  => $name,
			'type'  => $type,
		);

		if ( null !== $default ) {
			$field['default_value'] = $default;
		}

		$this->items[] = array_merge( $field, $settings );

		return $this;
	}

	/**
	 * Translate the editor-facing labels used by the local ACF groups.
	 *
	 * Technical field names and keys intentionally remain unchanged so saved
	 * WordPress data and template lookups keep working.
	 *
	 * @param string $label English source label.
	 * @return string Slovak editor label.
	 */
	private static function slovak_label( $label ) {
		$translations = array(
			'Hero'                         => 'Úvodná sekcia',
			'Training'                     => 'Tréningy',
			'Promotion'                    => 'Akcia',
			'Why us'                       => 'Prečo my',
			'Motivation'                   => 'Motivácia',
			'Mission'                      => 'Poslanie',
			'Team'                         => 'Tím',
			'Partner'                      => 'Partner',
			'Introduction'                 => 'Úvod',
			'Form'                         => 'Formulár',
			'Contact details & map'        => 'Kontaktné údaje a mapa',
			'Gym coaches'                  => 'Tréneri',
			'Nutrition'                    => 'Výživa',
			'Physiotherapy'                => 'Fyzioterapia',
			'Price list call to action'    => 'Výzva na akciu – cenník',
			'Choose your next level.'      => 'Vyberte si svoju ďalšiu úroveň.',
			'ProGym app'                   => 'Aplikácia ProGym',
			'Nutrition cooperation'        => 'Spolupráca s výživovým poradcom',
			'Back room'                    => 'Zadná miestnosť',
			'FAQ'                          => 'Časté otázky',
			'Hide this section'            => 'Skryť túto sekciu',
			'Hide this recommendation'     => 'Skryť toto odporúčanie',
			'Hide form section'            => 'Skryť sekciu formulára',
			'Hide contact details and map' => 'Skryť kontaktné údaje a mapu',
			'Hero image'                   => 'Obrázok úvodnej sekcie',
			'Hero headline'                => 'Hlavný nadpis úvodnej sekcie',
			'Badge'                        => 'Odznak',
			'Summary'                      => 'Zhrnutie',
			'Action label'                 => 'Text tlačidla',
			'Action URL'                   => 'URL tlačidla',
			'Section heading'              => 'Nadpis sekcie',
			'Section link label'           => 'Text odkazu sekcie',
			'Section link URL'             => 'URL odkazu sekcie',
			'First card title'             => 'Nadpis prvej karty',
			'First card URL'               => 'URL prvej karty',
			'First card image'             => 'Obrázok prvej karty',
			'Second card title'            => 'Nadpis druhej karty',
			'Second card URL'              => 'URL druhej karty',
			'Second card image'            => 'Obrázok druhej karty',
			'Eyebrow'                      => 'Nadpis nad sekciou',
			'Price label'                  => 'Popis ceny',
			'Promotional price'            => 'Akciová cena',
			'Regular price label'          => 'Popis bežnej ceny',
			'Regular price'                => 'Bežná cena',
			'Title first part'             => 'Prvá časť nadpisu',
			'Title highlighted part'       => 'Zvýraznená časť nadpisu',
			'Lead text'                    => 'Úvodný text',
			'Why us image'                 => 'Obrázok sekcie Prečo my',
			'First item icon'              => 'Ikona prvej položky',
			'First item title'             => 'Nadpis prvej položky',
			'First item text'              => 'Text prvej položky',
			'Second item icon'             => 'Ikona druhej položky',
			'Second item title'            => 'Nadpis druhej položky',
			'Second item text'             => 'Text druhej položky',
			'Third item icon'              => 'Ikona tretej položky',
			'Third item title'             => 'Nadpis tretej položky',
			'Third item text'              => 'Text tretej položky',
			'Motivation image'             => 'Motivačný obrázok',
			'Quote first part'             => 'Prvá časť citátu',
			'Quote highlighted part'       => 'Zvýraznená časť citátu',
			'Text'                         => 'Text',
			'Button label'                 => 'Text tlačidla',
			'Button URL'                   => 'URL tlačidla',
			'Hint'                         => 'Doplnkový text',
			'Image'                        => 'Obrázok',
			'Title'                        => 'Nadpis',
			'Title accent'                 => 'Zvýraznená časť nadpisu',
			'Description'                  => 'Popis',
			'First paragraph'              => 'Prvý odsek',
			'Second paragraph'             => 'Druhý odsek',
			'Drag hint'                    => 'Pokyn na posúvanie',
			'Team members count'           => 'Počet členov tímu',
			'End card title'               => 'Nadpis záverečnej karty',
			'End card text'                => 'Text záverečnej karty',
			'Coach count'                  => 'Počet trénerov',
			'Physiotherapist count'        => 'Počet fyzioterapeutov',
			'Timeline item count'          => 'Počet položiek časovej osi',
			'Number of items'              => 'Počet položiek',
			'Event posts'                  => 'Príspevky o podujatiach',
			'Event images'                 => 'Obrázky podujatia',
			'Section kicker'               => 'Krátky nadpis sekcie',
			'Section title'                => 'Nadpis sekcie',
			'Section title accent'         => 'Zvýraznená časť nadpisu sekcie',
			'Main title'                   => 'Hlavný nadpis',
			'Small title'                  => 'Malý nadpis',
			'Year'                         => 'Rok',
			'Short description 1'          => 'Krátky popis 1',
			'Short description 2'          => 'Krátky popis 2',
			'Full description'             => 'Celý popis',
			'Form heading'                 => 'Nadpis formulára',
			'Form shortcode'               => 'Shortcode formulára',
			'Address label'                => 'Popis adresy',
			'Address'                      => 'Adresa',
			'Email label'                  => 'Popis e-mailu',
			'Email address'                => 'E-mailová adresa',
			'Phone label'                  => 'Popis telefónu',
			'Phone number'                 => 'Telefónne číslo',
			'Google Maps embed URL'        => 'URL vloženej mapy Google',
			'Map accessibility title'      => 'Prístupný názov mapy',
			'Google Play small label'      => 'Malý text Google Play',
			'Google Play label'            => 'Text Google Play',
			'Google Play URL'              => 'URL Google Play',
			'App Store small label'        => 'Malý text App Store',
			'App Store label'              => 'Text App Store',
			'App Store URL'                => 'URL App Store',
			'Badge title'                  => 'Nadpis odznaku',
			'Badge text'                   => 'Text odznaku',
			'FAQ content'                  => 'Obsah častých otázok',
			'Right-side label'             => 'Text štítku vpravo',
		);

		if ( isset( $translations[ $label ] ) ) {
			return $translations[ $label ];
		}

		$patterns = array(
			'/^Member (\d+) image$/'                    => 'Člen $1 – obrázok',
			'/^Member (\d+) name$/'                     => 'Člen $1 – meno',
			'/^Member (\d+) role$/'                     => 'Člen $1 – pozícia',
			'/^Coach (\d+) profile\/card image$/'      => 'Tréner $1 – profilový obrázok/karta',
			'/^Coach (\d+) name$/'                      => 'Tréner $1 – meno',
			'/^Coach (\d+) role$/'                      => 'Tréner $1 – pozícia',
			'/^Coach (\d+) specialty$/'                 => 'Tréner $1 – špecializácia',
			'/^Coach (\d+) profile text$/'              => 'Tréner $1 – profilový text',
			'/^Coach (\d+) gallery media$/'             => 'Tréner $1 – médiá galérie',
			'/^Physiotherapist (\d+) image$/'           => 'Fyzioterapeut $1 – obrázok',
			'/^Physiotherapist (\d+) name$/'            => 'Fyzioterapeut $1 – meno',
			'/^Physiotherapist (\d+) specialty$/'       => 'Fyzioterapeut $1 – špecializácia',
			'/^Physiotherapist (\d+) Facebook URL$/'    => 'Fyzioterapeut $1 – URL Facebooku',
			'/^Physiotherapist (\d+) Instagram URL$/'   => 'Fyzioterapeut $1 – URL Instagramu',
			'/^Physiotherapist (\d+) phone$/'           => 'Fyzioterapeut $1 – telefónne číslo',
			'/^Timeline item (\d+) image$/'              => 'Položka časovej osi $1 – obrázok',
			'/^Timeline item (\d+) year$/'               => 'Položka časovej osi $1 – rok',
			'/^Timeline item (\d+) short label$/'        => 'Položka časovej osi $1 – krátky popis',
			'/^Timeline item (\d+) title$/'              => 'Položka časovej osi $1 – nadpis',
			'/^Timeline item (\d+) description$/'        => 'Položka časovej osi $1 – popis',
			'/^Item (\d+) title$/'                       => 'Položka $1 – nadpis',
			'/^Item (\d+) description$/'                 => 'Položka $1 – popis',
			'/^Item (\d+) badge$/'                       => 'Položka $1 – odznak',
			'/^Item (\d+) price$/'                       => 'Položka $1 – cena',
			'/^Item (\d+) action label$/'                => 'Položka $1 – text tlačidla',
			'/^Item (\d+) action URL$/'                  => 'Položka $1 – URL tlačidla',
			'/^Item (\d+) note$/'                        => 'Položka $1 – poznámka',
			'/^Plan (\d+) featured$/'                    => 'Plán $1 – odporúčaný',
			'/^Plan (\d+) tag$/'                         => 'Plán $1 – štítok',
			'/^Plan (\d+) price$/'                       => 'Plán $1 – cena',
			'/^Plan (\d+) price label$/'                 => 'Plán $1 – popis ceny',
			'/^Plan (\d+) title$/'                       => 'Plán $1 – nadpis',
			'/^Plan (\d+) description$/'                 => 'Plán $1 – popis',
			'/^Plan (\d+) first list title$/'            => 'Plán $1 – nadpis prvého zoznamu',
			'/^Plan (\d+) first list items$/'            => 'Plán $1 – položky prvého zoznamu',
			'/^Plan (\d+) second list title$/'           => 'Plán $1 – nadpis druhého zoznamu',
			'/^Plan (\d+) second list items$/'           => 'Plán $1 – položky druhého zoznamu',
			'/^Plan (\d+) note$/'                        => 'Plán $1 – poznámka',
			'/^Plan (\d+) action label$/'                => 'Plán $1 – text tlačidla',
			'/^Plan (\d+) action URL$/'                  => 'Plán $1 – URL tlačidla',
		);

		foreach ( $patterns as $pattern => $replacement ) {
			if ( preg_match( $pattern, $label ) ) {
				return preg_replace( $pattern, $replacement, $label );
			}
		}

		return $label;
	}

	/**
	 * Backward-compatible alias for field().
	 *
	 * @param string              $key      Field-key suffix.
	 * @param string              $label    Field label.
	 * @param string              $name     Field name.
	 * @param string              $type     ACF field type.
	 * @param mixed               $default  Optional default value.
	 * @param array<string,mixed> $settings Additional ACF field settings.
	 * @return self
	 */
	public function add_field( $key, $label, $name, $type = 'text', $default = null, $settings = array() ) {
		return $this->field( $key, $label, $name, $type, $default, $settings );
	}

	/**
	 * Return the completed field definitions.
	 *
	 * @return array<int,array<string,mixed>>
	 */
	public function fields() {
		return $this->items;
	}

	/**
	 * Backward-compatible alias for fields().
	 *
	 * @return array<int,array<string,mixed>>
	 */
	public function get_fields() {
		return $this->fields();
	}
}
