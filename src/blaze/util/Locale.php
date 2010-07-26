<?php
namespace blaze\util;
use blaze\lang\Object,
    blaze\io\Serializable,
    blaze\lang\Cloneable,
    blaze\lang\StaticInitialization;

/**
 * Description of Locale
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
final class Locale extends Object implements Cloneable, Serializable, StaticInitialization {

    private static $cache = array();// = new ConcurrentHashMap<String, Locale>(32);

    /** Useful constant for language.
     */
    public static $ENGLISH;

    /** Useful constant for language.
     */
    public static $FRENCH;

    /** Useful constant for language.
     */
    public static $GERMAN;

    /** Useful constant for language.
     */
    public static $ITALIAN;

    /** Useful constant for language.
     */
    public static $JAPANESE;

    /** Useful constant for language.
     */
    public static $KOREAN;

    /** Useful constant for language.
     */
    public static $CHINESE;

    /** Useful constant for language.
     */
    public static $SIMPLIFIED_CHINESE;

    /** Useful constant for language.
     */
    public static $TRADITIONAL_CHINESE;

    /** Useful constant for country.
     */
    public static $FRANCE;

    /** Useful constant for country.
     */
    public static $GERMANY;

    /** Useful constant for country.
     */
    public static $ITALY;

    /** Useful constant for country.
     */
    public static $JAPAN;

    /** Useful constant for country.
     */
    public static $KOREA;

    /** Useful constant for country.
     */
    public static $CHINA;

    /** Useful constant for country.
     */
    public static $PRC;

    /** Useful constant for country.
     */
    public static $TAIWAN;

    /** Useful constant for country.
     */
    public static $UK;

    /** Useful constant for country.
     */
    public static $US;

    /** Useful constant for country.
     */
    public static $CANADA;

    /** Useful constant for country.
     */
    public static $CANADA_FRENCH;

    /**
     * Useful constant for the root locale.  The root locale is the locale whose
     * language, country, and variant are empty ("") strings.  This is regarded
     * as the base locale of all locales, and is used as the language/country
     * neutral locale for the locale sensitive operations.
     *
     * @since 1.6
     */
    //public static $ROOT = self::getSingleton("__", "", "");


    private static $isoLanguages = null;

    private static $isoCountries = null;

    private static $defaultLocale = null;

    private $hash = -1;

    private $language;
    private $country;
    private $variant;

    /**
     * Beschreibung
     */
    public function __construct($language, $country = '', $variant = ''){
        $this->language = $this->convertOldISOCodes($language);
        $this->country = strtoupper($country);
        $this->variant = $variant;
    }

    public static function staticInit() {
        self::$ENGLISH = self::getSingleton("en__", "en", "");
        self::$FRENCH = self::getSingleton("fr__", "fr", "");
        self::$GERMAN = self::getSingleton("de__", "de", "");
        self::$ITALIAN = self::getSingleton("it__", "it", "");
        self::$JAPANESE = self::getSingleton("ja__", "ja", "");
        self::$KOREAN = self::getSingleton("ko__", "ko", "");
        self::$CHINESE = self::getSingleton("zh__", "zh", "");
        self::$SIMPLIFIED_CHINESE = self::getSingleton("zh_CN_", "zh", "CN");
        self::$TRADITIONAL_CHINESE = self::getSingleton("zh_TW_", "zh", "TW");
        self::$FRANCE = self::getSingleton("fr_FR_", "fr", "FR");
        self::$GERMANY = self::getSingleton("de_DE_", "de", "DE");
        self::$ITALY = self::getSingleton("it_IT_", "it", "IT");
        self::$JAPAN = self::getSingleton("ja_JP_", "ja", "JP");
        self::$KOREA = self::getSingleton("ko_KR_", "ko", "KR");
        self::$CHINA = self::$SIMPLIFIED_CHINESE;
        self::$PRC = self::$SIMPLIFIED_CHINESE;
        self::$TAIWAN = self::$TRADITIONAL_CHINESE;
        self::$UK = self::getSingleton("en_GB_", "en", "GB");
        self::$US = self::getSingleton("en_US_", "en", "US");
        self::$CANADA = self::getSingleton("en_CA_", "en", "CA");
        self::$CANADA_FRENCH = self::getSingleton("fr_CA_", "fr", "CA");
        setlocale(LC_ALL,0);
    }

    /**
     * Beschreibung
     *
     * @param 	blaze\lang\Object $var Beschreibung des Parameters
     * @return 	blaze\lang\Object Beschreibung was die Methode zurückliefert
     * @see 	Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
     * @throws	blaze\lang\Exception
     * @todo	Etwas was noch erledigt werden muss
     */
     private static function getSingleton($key, $language, $country){
        if(!isset(self::$cache[$key]))
            self::$cache[$key] = new self($language,$country);

        return self::$cache[$key];
     }

     private function convertOldISOCodes($language) {
        // we accept both the old and the new ISO codes for the languages whose ISO
        // codes have changed, but we always store the OLD code, for backward compatibility
        $language = strtolower($language);
        if ($language == "he") {
            return "iw";
        } else if ($language == "yi") {
            return "ji"; 
        } else if ($language == "id") {
            return "in";
        } else {
            return $language;
        }
    }

    public function getLanguage() {
        return $this->language;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getVariant() {
        return $this->variant;
    }

    

    /**
     * Gets the current value of the default locale for this instance
     * of the Java Virtual Machine.
     * <p>
     * The Java Virtual Machine sets the default locale during startup
     * based on the host environment. It is used by many locale-sensitive
     * methods if no locale is explicitly specified.
     * It can be changed using the
     * {@link #setDefault(java.util.Locale) setDefault} method.
     *
     * @return blaze\util\Locale the default locale for this instance of the Java Virtual Machine
     */
    public static function getDefault() {
        if (self::$defaultLocale == null) {
            //var_dump(setlocale(LC_ALL,0));
//            String language, region, country, variant;
//            language = (String) AccessController.doPrivileged(
//                            new GetPropertyAction("user.language", "en"));
//            // for compatibility, check for old user.region property
//            region = (String) AccessController.doPrivileged(
//                            new GetPropertyAction("user.region"));
//            if (region != null) {
//                // region can be of form country, country_variant, or _variant
//                int i = region.indexOf('_');
//                if (i >= 0) {
//                    country = region.substring(0, i);
//                    variant = region.substring(i + 1);
//                } else {
//                    country = region;
//                    variant = "";
//                }
//            } else {
//                country = (String) AccessController.doPrivileged(
//                                new GetPropertyAction("user.country", ""));
//                variant = (String) AccessController.doPrivileged(
//                                new GetPropertyAction("user.variant", ""));
//            }
//            defaultLocale = getInstance(language, country, variant);
        }
        return self::$defaultLocale;
    }

    /**
     * Sets the default locale for this instance of the Java Virtual Machine.
     * This does not affect the host locale.
     * <p>
     * If there is a security manager, its <code>checkPermission</code>
     * method is called with a <code>PropertyPermission("user.language", "write")</code>
     * permission before the default locale is changed.
     * <p>
     * The Java Virtual Machine sets the default locale during startup
     * based on the host environment. It is used by many locale-sensitive
     * methods if no locale is explicitly specified.
     * <p>
     * Since changing the default locale may affect many different areas
     * of functionality, this method should only be used if the caller
     * is prepared to reinitialize locale-sensitive code running
     * within the same Java Virtual Machine.
     *
     * @throws SecurityException
     *        if a security manager exists and its
     *        <code>checkPermission</code> method doesn't allow the operation.
     * @throws NullPointerException if <code>newLocale</code> is null
     * @param newLocale the new default locale
     * @see SecurityManager#checkPermission
     * @see java.util.PropertyPermission
     */
//    public static synchronized void setDefault(Locale newLocale) {
//        if (newLocale == null)
//            throw new NullPointerException("Can't set default locale to NULL");
//
//        SecurityManager sm = System.getSecurityManager();
//        if (sm != null) sm.checkPermission(new PropertyPermission
//                        ("user.language", "write"));
//            defaultLocale = newLocale;
//    }


    /**
     * Returns an array of all installed locales.
     * The returned array represents the union of locales supported
     * by the Java runtime environment and by installed
     * {@link java.util.spi.LocaleServiceProvider LocaleServiceProvider}
     * implementations.  It must contain at least a <code>Locale</code>
     * instance equal to {@link java.util.Locale#US Locale.US}.
     *
     * @return An array of installed locales.
     */
//    public static Locale[] getAvailableLocales() {
//        return LocaleServiceProviderPool.getAllAvailableLocales();
//    }

    /**
     * Returns a list of all 2-letter country codes defined in ISO 3166.
     * Can be used to create Locales.
     */
//    public static String[] getISOCountries() {
//        if (isoCountries == null) {
//            isoCountries = getISO2Table(LocaleISOData.isoCountryTable);
//        }
//        String[] result = new String[isoCountries.length];
//        System.arraycopy(isoCountries, 0, result, 0, isoCountries.length);
//        return result;
//    }

    /**
     * Returns a list of all 2-letter language codes defined in ISO 639.
     * Can be used to create Locales.
     * [NOTE:  ISO 639 is not a stable standard-- some languages' codes have changed.
     * The list this function returns includes both the new and the old codes for the
     * languages whose codes have changed.]
     */
//    public static String[] getISOLanguages() {
//        if (isoLanguages == null) {
//            isoLanguages = getISO2Table(LocaleISOData.isoLanguageTable);
//        }
//        String[] result = new String[isoLanguages.length];
//        System.arraycopy(isoLanguages, 0, result, 0, isoLanguages.length);
//        return result;
//    }
//
//    private static final String[] getISO2Table(String table) {
//	int len = table.length() / 5;
//	String[] isoTable = new String[len];
//	for (int i = 0, j = 0; i < len; i++, j += 5) {
//	    isoTable[i] = table.substring(j, j + 2);
//	}
//	return isoTable;
//    }


    /**
     * Getter for the programmatic name of the entire locale,
     * with the language, country and variant separated by underbars.
     * Language is always lower case, and country is always upper case.
     * If the language is missing, the string will begin with an underbar.
     * If both the language and country fields are missing, this function
     * will return the empty string, even if the variant field is filled in
     * (you can't have a locale with just a variant-- the variant must accompany
     * a valid language or country code).
     * Examples: "en", "de_DE", "_GB", "en_US_WIN", "de__POSIX", "fr__MAC"
     * @see #getDisplayName
     */
//    public final String toString() {
//        boolean l = language.length() != 0;
//        boolean c = country.length() != 0;
//        boolean v = variant.length() != 0;
//        StringBuilder result = new StringBuilder(language);
//        if (c||(l&&v)) {
//            result.append('_').append(country); // This may just append '_'
//        }
//        if (v&&(l||c)) {
//            result.append('_').append(variant);
//        }
//        return result.toString();
//    }

    /**
     * Returns a three-letter abbreviation for this locale's language.  If the locale
     * doesn't specify a language, this will be the empty string.  Otherwise, this will
     * be a lowercase ISO 639-2/T language code.
     * The ISO 639-2 language codes can be found on-line at
     * <a href="http://www.loc.gov/standards/iso639-2/englangn.html">
     * <code>http://www.loc.gov/standards/iso639-2/englangn.html</code>.</a>
     * @exception MissingResourceException Throws MissingResourceException if the
     * three-letter language abbreviation is not available for this locale.
     */
//    public String getISO3Language() throws MissingResourceException {
//	String language3 = getISO3Code(language, LocaleISOData.isoLanguageTable);
//        if (language3 == null) {
//            throw new MissingResourceException("Couldn't find 3-letter language code for "
//                    + language, "FormatData_" + toString(), "ShortLanguage");
//        }
//        return language3;
//    }

    /**
     * Returns a three-letter abbreviation for this locale's country.  If the locale
     * doesn't specify a country, this will be the empty string.  Otherwise, this will
     * be an uppercase ISO 3166 3-letter country code.
     * The ISO 3166-2 country codes can be found on-line at
     * <a href="http://www.davros.org/misc/iso3166.txt">
     * <code>http://www.davros.org/misc/iso3166.txt</code>.</a>
     * @exception MissingResourceException Throws MissingResourceException if the
     * three-letter country abbreviation is not available for this locale.
     */
//    public String getISO3Country() throws MissingResourceException {
//	String country3 = getISO3Code(country, LocaleISOData.isoCountryTable);
//        if (country3 == null) {
//            throw new MissingResourceException("Couldn't find 3-letter country code for "
//                    + country, "FormatData_" + toString(), "ShortCountry");
//        }
//	return country3;
//    }

//    private static final String getISO3Code(String iso2Code, String table) {
//	int codeLength = iso2Code.length();
//        if (codeLength == 0) {
//            return "";
//        }
//
//	int tableLength = table.length();
//        int index = tableLength;
//	if (codeLength == 2) {
//	    char c1 = iso2Code.charAt(0);
//	    char c2 = iso2Code.charAt(1);
//	    for (index = 0; index < tableLength; index += 5) {
//		if (table.charAt(index) == c1
//		    && table.charAt(index + 1) == c2) {
//		    break;
//		}
//	    }
//	}
//        return index < tableLength ? table.substring(index + 2, index + 5) : null;
//    }

    /**
     * Returns a name for the locale's language that is appropriate for display to the
     * user.
     * If possible, the name returned will be localized for the default locale.
     * For example, if the locale is fr_FR and the default locale
     * is en_US, getDisplayLanguage() will return "French"; if the locale is en_US and
     * the default locale is fr_FR, getDisplayLanguage() will return "anglais".
     * If the name returned cannot be localized for the default locale,
     * (say, we don't have a Japanese name for Croatian),
     * this function falls back on the English name, and uses the ISO code as a last-resort
     * value.  If the locale doesn't specify a language, this function returns the empty string.
     */
//    public final String getDisplayLanguage() {
//        return getDisplayLanguage(getDefault());
//    }

    /**
     * Returns a name for the locale's language that is appropriate for display to the
     * user.
     * If possible, the name returned will be localized according to inLocale.
     * For example, if the locale is fr_FR and inLocale
     * is en_US, getDisplayLanguage() will return "French"; if the locale is en_US and
     * inLocale is fr_FR, getDisplayLanguage() will return "anglais".
     * If the name returned cannot be localized according to inLocale,
     * (say, we don't have a Japanese name for Croatian),
     * this function falls back on the English name, and finally
     * on the ISO code as a last-resort value.  If the locale doesn't specify a language,
     * this function returns the empty string.
     *
     * @exception NullPointerException if <code>inLocale</code> is <code>null</code>
     */
//    public String getDisplayLanguage(Locale inLocale) {
//        return getDisplayString(language, inLocale, DISPLAY_LANGUAGE);
//    }

    /**
     * Returns a name for the locale's country that is appropriate for display to the
     * user.
     * If possible, the name returned will be localized for the default locale.
     * For example, if the locale is fr_FR and the default locale
     * is en_US, getDisplayCountry() will return "France"; if the locale is en_US and
     * the default locale is fr_FR, getDisplayCountry() will return "Etats-Unis".
     * If the name returned cannot be localized for the default locale,
     * (say, we don't have a Japanese name for Croatia),
     * this function falls back on the English name, and uses the ISO code as a last-resort
     * value.  If the locale doesn't specify a country, this function returns the empty string.
     */
//    public final String getDisplayCountry() {
//        return getDisplayCountry(getDefault());
//    }

    /**
     * Returns a name for the locale's country that is appropriate for display to the
     * user.
     * If possible, the name returned will be localized according to inLocale.
     * For example, if the locale is fr_FR and inLocale
     * is en_US, getDisplayCountry() will return "France"; if the locale is en_US and
     * inLocale is fr_FR, getDisplayCountry() will return "Etats-Unis".
     * If the name returned cannot be localized according to inLocale.
     * (say, we don't have a Japanese name for Croatia),
     * this function falls back on the English name, and finally
     * on the ISO code as a last-resort value.  If the locale doesn't specify a country,
     * this function returns the empty string.
     *
     * @exception NullPointerException if <code>inLocale</code> is <code>null</code>
     */
//    public String getDisplayCountry(Locale inLocale) {
//        return getDisplayString(country, inLocale, DISPLAY_COUNTRY);
//    }

//    private String getDisplayString(String code, Locale inLocale, int type) {
//        if (code.length() == 0) {
//            return "";
//        }
//
//        if (inLocale == null) {
//            throw new NullPointerException();
//        }
//
//        try {
//            OpenListResourceBundle bundle = LocaleData.getLocaleNames(inLocale);
//            String key = (type == DISPLAY_VARIANT ? "%%"+code : code);
//            String result = null;
//
//            // Check whether a provider can provide an implementation that's closer
//            // to the requested locale than what the Java runtime itself can provide.
//            LocaleServiceProviderPool pool =
//                LocaleServiceProviderPool.getPool(LocaleNameProvider.class);
//            if (pool.hasProviders()) {
//                result = pool.getLocalizedObject(
//                                    LocaleNameGetter.INSTANCE,
//                                    inLocale, bundle, key,
//                                    type, code);
//            }
//
//            if (result == null) {
//                result = bundle.getString(key);
//            }
//
//            if (result != null) {
//                return result;
//            }
//        }
//        catch (Exception e) {
//            // just fall through
//        }
//        return code;
//    }

    /**
     * Returns a name for the locale's variant code that is appropriate for display to the
     * user.  If possible, the name will be localized for the default locale.  If the locale
     * doesn't specify a variant code, this function returns the empty string.
     */
//    public final String getDisplayVariant() {
//        return getDisplayVariant(getDefault());
//    }

    /**
     * Returns a name for the locale's variant code that is appropriate for display to the
     * user.  If possible, the name will be localized for inLocale.  If the locale
     * doesn't specify a variant code, this function returns the empty string.
     *
     * @exception NullPointerException if <code>inLocale</code> is <code>null</code>
     */
//    public String getDisplayVariant(Locale inLocale) {
//        if (variant.length() == 0)
//            return "";
//
//        OpenListResourceBundle bundle = LocaleData.getLocaleNames(inLocale);
//
//        String names[] = getDisplayVariantArray(bundle, inLocale);
//
//        // Get the localized patterns for formatting a list, and use
//        // them to format the list.
//        String listPattern = null;
//        String listCompositionPattern = null;
//        try {
//            listPattern = bundle.getString("ListPattern");
//            listCompositionPattern = bundle.getString("ListCompositionPattern");
//        } catch (MissingResourceException e) {
//        }
//        return formatList(names, listPattern, listCompositionPattern);
//    }

    /**
     * Returns a name for the locale that is appropriate for display to the
     * user.  This will be the values returned by getDisplayLanguage(), getDisplayCountry(),
     * and getDisplayVariant() assembled into a single string.  The display name will have
     * one of the following forms:<p><blockquote>
     * language (country, variant)<p>
     * language (country)<p>
     * language (variant)<p>
     * country (variant)<p>
     * language<p>
     * country<p>
     * variant<p></blockquote>
     * depending on which fields are specified in the locale.  If the language, country,
     * and variant fields are all empty, this function returns the empty string.
     */
//    public final String getDisplayName() {
//        return getDisplayName(getDefault());
//    }

    /**
     * Returns a name for the locale that is appropriate for display to the
     * user.  This will be the values returned by getDisplayLanguage(), getDisplayCountry(),
     * and getDisplayVariant() assembled into a single string.  The display name will have
     * one of the following forms:<p><blockquote>
     * language (country, variant)<p>
     * language (country)<p>
     * language (variant)<p>
     * country (variant)<p>
     * language<p>
     * country<p>
     * variant<p></blockquote>
     * depending on which fields are specified in the locale.  If the language, country,
     * and variant fields are all empty, this function returns the empty string.
     *
     * @exception NullPointerException if <code>inLocale</code> is <code>null</code>
     */
//    public String getDisplayName(Locale inLocale) {
//        OpenListResourceBundle bundle = LocaleData.getLocaleNames(inLocale);
//
//        String languageName = getDisplayLanguage(inLocale);
//        String countryName = getDisplayCountry(inLocale);
//        String[] variantNames = getDisplayVariantArray(bundle, inLocale);
//
//        // Get the localized patterns for formatting a display name.
//        String displayNamePattern = null;
//        String listPattern = null;
//        String listCompositionPattern = null;
//        try {
//            displayNamePattern = bundle.getString("DisplayNamePattern");
//            listPattern = bundle.getString("ListPattern");
//            listCompositionPattern = bundle.getString("ListCompositionPattern");
//        } catch (MissingResourceException e) {
//        }
//
//        // The display name consists of a main name, followed by qualifiers.
//        // Typically, the format is "MainName (Qualifier, Qualifier)" but this
//        // depends on what pattern is stored in the display locale.
//        String   mainName       = null;
//        String[] qualifierNames = null;
//
//        // The main name is the language, or if there is no language, the country.
//        // If there is neither language nor country (an anomalous situation) then
//        // the display name is simply the variant's display name.
//        if (languageName.length() != 0) {
//            mainName = languageName;
//            if (countryName.length() != 0) {
//                qualifierNames = new String[variantNames.length + 1];
//                System.arraycopy(variantNames, 0, qualifierNames, 1, variantNames.length);
//                qualifierNames[0] = countryName;
//            }
//            else qualifierNames = variantNames;
//        }
//        else if (countryName.length() != 0) {
//            mainName = countryName;
//            qualifierNames = variantNames;
//        }
//        else {
//            return formatList(variantNames, listPattern, listCompositionPattern);
//        }
//
//        // Create an array whose first element is the number of remaining
//        // elements.  This serves as a selector into a ChoiceFormat pattern from
//        // the resource.  The second and third elements are the main name and
//        // the qualifier; if there are no qualifiers, the third element is
//        // unused by the format pattern.
//        Object[] displayNames = {
//            new Integer(qualifierNames.length != 0 ? 2 : 1),
//            mainName,
//            // We could also just call formatList() and have it handle the empty
//            // list case, but this is more efficient, and we want it to be
//            // efficient since all the language-only locales will not have any
//            // qualifiers.
//            qualifierNames.length != 0 ? formatList(qualifierNames, listPattern, listCompositionPattern) : null
//        };
//
//        if (displayNamePattern != null) {
//            return new MessageFormat(displayNamePattern).format(displayNames);
//        }
//        else {
//            // If we cannot get the message format pattern, then we use a simple
//            // hard-coded pattern.  This should not occur in practice unless the
//            // installation is missing some core files (FormatData etc.).
//            StringBuilder result = new StringBuilder();
//            result.append((String)displayNames[1]);
//            if (displayNames.length > 2) {
//                result.append(" (");
//                result.append((String)displayNames[2]);
//                result.append(')');
//            }
//            return result.toString();
//        }
//    }

    /**
     * Override hashCode.
     * Since Locales are often used in hashtables, caches the value
     * for speed.
     */
    public function hashCode() {
        $hc = $this->hash;
        if ($hc == 0) {
            $language = new String($this->language);
            $country = new String($this->country);
            $variant = new String($this->variant);
	    $hc = ($language->hashCode() << 8) ^ $country->hashCode() ^ ($variant->hashCode() << 4);
            $this->hash = $hc;
        }
        return $hc;
    }

    // Overrides

    /**
     * Returns true if this Locale is equal to another object.  A Locale is
     * deemed equal to another Locale with identical language, country,
     * and variant, and unequal to all other objects.
     *
     * @return boolean true if this Locale is equal to the specified object.
     */

    public function equals(Object $obj) {
        if ($this == $obj)                      // quick check
            return true;
        if (!($obj instanceof Locale))
            return false;
	return $this->language == $obj->language
            && $this->country == $obj->country
            && $this->variant == $obj->variant;
    }


    /**
     * Return an array of the display names of the variant.
     * @param bundle the ResourceBundle to use to get the display names
     * @return an array of display names, possible of zero length.
     */
//    private String[] getDisplayVariantArray(OpenListResourceBundle bundle, Locale inLocale) {
//        // Split the variant name into tokens separated by '_'.
//        StringTokenizer tokenizer = new StringTokenizer(variant, "_");
//        String[] names = new String[tokenizer.countTokens()];
//
//        // For each variant token, lookup the display name.  If
//        // not found, use the variant name itself.
//        for (int i=0; i<names.length; ++i) {
//            names[i] = getDisplayString(tokenizer.nextToken(),
//                                inLocale, DISPLAY_VARIANT);
//        }
//
//        return names;
//    }

    /**
     * Format a list using given pattern strings.
     * If either of the patterns is null, then a the list is
     * formatted by concatenation with the delimiter ','.
     * @param stringList the list of strings to be formatted.
     * @param listPattern should create a MessageFormat taking 0-3 arguments
     * and formatting them into a list.
     * @param listCompositionPattern should take 2 arguments
     * and is used by composeList.
     * @return a string representing the list.
     */
//    private static String formatList(String[] stringList, String listPattern, String listCompositionPattern) {
//        // If we have no list patterns, compose the list in a simple,
//        // non-localized way.
//        if (listPattern == null || listCompositionPattern == null) {
//            StringBuffer result = new StringBuffer();
//            for (int i=0; i<stringList.length; ++i) {
//                if (i>0) result.append(',');
//                result.append(stringList[i]);
//            }
//            return result.toString();
//        }
//
//        // Compose the list down to three elements if necessary
//        if (stringList.length > 3) {
//            MessageFormat format = new MessageFormat(listCompositionPattern);
//            stringList = composeList(format, stringList);
//        }
//
//        // Rebuild the argument list with the list length as the first element
//        Object[] args = new Object[stringList.length + 1];
//        System.arraycopy(stringList, 0, args, 1, stringList.length);
//        args[0] = new Integer(stringList.length);
//
//        // Format it using the pattern in the resource
//        MessageFormat format = new MessageFormat(listPattern);
//        return format.format(args);
//    }

    /**
     * Given a list of strings, return a list shortened to three elements.
     * Shorten it by applying the given format to the first two elements
     * recursively.
     * @param format a format which takes two arguments
     * @param list a list of strings
     * @return if the list is three elements or shorter, the same list;
     * otherwise, a new list of three elements.
     */
//    private static String[] composeList(MessageFormat format, String[] list) {
//        if (list.length <= 3) return list;
//
//        // Use the given format to compose the first two elements into one
//        String[] listItems = { list[0], list[1] };
//        String newItem = format.format(listItems);
//
//        // Form a new list one element shorter
//        String[] newList = new String[list.length-1];
//        System.arraycopy(list, 2, newList, 1, newList.length-1);
//        newList[0] = newItem;
//
//        // Recurse
//        return composeList(format, newList);
//    }

    /**
     * Replace the deserialized Locale object with a newly
     * created object. Newer language codes are replaced with older ISO
     * codes. The country and variant codes are replaced with internalized
     * String copies.
     */
//    private Object readResolve() throws java.io.ObjectStreamException {
//        return getInstance(language, country, variant);
//    }

}

?>
