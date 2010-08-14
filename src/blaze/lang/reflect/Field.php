<?php
namespace blaze\lang\reflect;
use blaze\lang\Object;
use blaze\lang\ClassWrapper;
use blaze\lang\String;
/**
 * Field class represents a field which is defined within a class.
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @author  Christian Beikov
 * @todo    Methods are not all implemented and documentation is not complete.
 */
class Field extends Object{

    private $property;

    /**
     * Description of the constructor of Field
     */
    public function __construct(\ReflectionProperty $property){
        $this->property = $property;
    }


    /**
     * Returns the <code>Class</code> object representing the class or interface
     * that declares the field represented by this <code>Field</code> object.
     *
     * @return blaze\lang\ClassWrapper
     */
    public function getDeclaringClass() {
	return ClassWrapper::forName($this->property->getDeclaringClass()->getName());
    }

    /**
     * @return blaze\lang\String
     * Returns the name of the field represented by this <code>Field</code> object.
     */
    public function getName() {
	return new String($this->property->getName());
    }

    /**
     * Returns the Java language modifiers for the field represented
     * by this <code>Field</code> object, as an integer. The <code>Modifier</code> class should
     * be used to decode the modifiers.
     *
     * @see Modifier
     * @return integer
     */
    public function getModifiers() {
	return $this->property->getModifiers();
    }

    /**
     * Returns <tt>true</tt> if this field represents an element of
     * an enumerated type; returns <tt>false</tt> otherwise.
     *
     * @return boolean <tt>true</tt> if and only if this field represents an element of
     * an enumerated type.
     * @since 1.5
     */
    public function isEnumConstant() {
        return ($this->getModifiers() & Modifier::ENUM) != 0;
    }

    /**
     * Returns a <code>Class</code> object that identifies the
     * declared type for the field represented by this
     * <code>Field</code> object.
     *
     * @return string a <code>Class</code> object identifying the declared
     * type of the field represented by this object
     */
    public function getType(Object $obj) {
        $this->property->setAccessible(true);
        $value = $this->property->getValue($obj);
        if($value === null){
            $annot = $this->getAnnotations();
            if(array_key_exists('var', $annot) && isset($annot['var'][0])){
                return $annot['var'][0];
            }
            return 'null';
        }else if(is_object($value)){
            return get_class($value);
        }else if(is_array($value)){
            return 'array';
        }else if(is_bool($value)){
            return 'boolean';
        }else if(is_float($value)){
            return 'float';
        }else if(is_double($value)){
            return 'double';
        }else if(is_int($value)){
            return 'integer';
        }else if(is_resource($value)){
            return 'ressource';
        }else if(is_string($value)){
            return 'string';
        }else{
            return 'undefined';
        }
    }


    /**
     * Compares this <code>Field</code> against the specified object.  Returns
     * true if the objects are the same.  Two <code>Field</code> objects are the same if
     * they were declared by the same class and have the same name
     * and type.
     *
     * @return boolean
     */
    public function equals(\blaze\lang\Reflectable $obj) {
	if ($obj != null && $obj instanceof Field) {
	    return ($this->getDeclaringClass() == $other->getDeclaringClass())
                && ($this->getName() == $other->getName())
		&& ($this->getType() == $other->getType());
	}
	return false;
    }

    /**
     * Returns a hashcode for this <code>Field</code>.  This is computed as the
     * exclusive-or of the hashcodes for the underlying field's
     * declaring class name and its name.
     *
     * @return integer
     */
    public function hashCode() {
	//return getDeclaringClass().getName().hashCode() ^ getName().hashCode();
    }

    /**
     * Returns a string describing this <code>Field</code>.  The format is
     * the access modifiers for the field, if any, followed
     * by the field type, followed by a space, followed by
     * the fully-qualified name of the class declaring the field,
     * followed by a period, followed by the name of the field.
     * For example:
     * <pre>
     *    public static final int java.lang.Thread.MIN_PRIORITY
     *    private int java.io.FileDescriptor.fd
     * </pre>
     *
     * <p>The modifiers are placed in canonical order as specified by
     * "The Java Language Specification".  This is <tt>public</tt>,
     * <tt>protected</tt> or <tt>private</tt> first, and then other
     * modifiers in the following order: <tt>static</tt>, <tt>final</tt>,
     * <tt>transient</tt>, <tt>volatile</tt>.
     *
     * @return string
     */
    public function __toString() {
	$mod = $this->getModifiers();
	return ((($mod == 0) ? "" : (Modifier::toString(mod) + " "))
	    + $this->getTypeName($this->getType()) + " "
	    + $this->getTypeName($this->getDeclaringClass()) + "."
	    + $this->getName());
    }

    /**
     * Returns if the field whether has the default modifier or not
     *
     * @return boolean
     */
    public function isDefault(){
        return $this->property->isDefault();
    }

    /**
     * Returns if the field whether has the private modifier or not
     *
     * @return boolean
     */
    public function isPrivate(){
        return $this->property->isPrivate();
    }

    /**
     * Returns if the field whether has the protected modifier or not
     *
     * @return boolean
     */
    public function isProtected(){
        return $this->property->isProtected();
    }

    /**
     * Returns if the field whether has the public modifier or not
     *
     * @return boolean
     */
    public function isPublic(){
        return $this->property->isPublic();
    }

    /**
     * Returns if the field whether has the static modifier or not
     *
     * @return boolean
     */
    public function isStatic(){
        return $this->property->isStatic();
    }

    public function getDocComment(){
        return $this->property->getDocComment();
    }

    /**
     * Returns the value of the field represented by this <code>Field</code>, on
     * the specified object. The value is automatically wrapped in an
     * object if it has a primitive type.
     *
     * <p>The underlying field's value is obtained as follows:
     *
     * <p>If the underlying field is a static field, the <code>obj</code> argument
     * is ignored; it may be null.
     *
     * <p>Otherwise, the underlying field is an instance field.  If the
     * specified <code>obj</code> argument is null, the method throws a
     * <code>NullPointerException.</code> If the specified object is not an
     * instance of the class or interface declaring the underlying
     * field, the method throws an <code>IllegalArgumentException</code>.
     *
     * <p>If this <code>Field</code> object enforces Java language access control, and
     * the underlying field is inaccessible, the method throws an
     * <code>IllegalAccessException</code>.
     * If the underlying field is static, the class that declared the
     * field is initialized if it has not already been initialized.
     *
     * <p>Otherwise, the value is retrieved from the underlying instance
     * or static field.  If the field has a primitive type, the value
     * is wrapped in an object before being returned, otherwise it is
     * returned as is.
     *
     * <p>If the field is hidden in the type of <code>obj</code>,
     * the field's value is obtained according to the preceding rules.
     *
     * @param obj object from which the represented field's value is
     * to be extracted
     * @return blaze\lang\Object the value of the represented field in object
     * <tt>obj</tt>; primitive values are wrapped in an appropriate
     * object before being returned
     *
     * @exception IllegalAccessException    if the underlying field
     *              is inaccessible.
     * @exception IllegalArgumentException  if the specified object is not an
     *              instance of the class or interface declaring the underlying
     *              field (or a subclass or implementor thereof).
     * @exception NullPointerException      if the specified object is null
     *              and the field is an instance field.
     * @exception ExceptionInInitializerError if the initialization provoked
     *              by this method fails.
     */
    public function get(Object $obj)
        //throws IllegalArgumentException, IllegalAccessException
    {
        $this->property->setAccessible(true);
        return $this->property->getValue($obj);
        //return $this->getFieldAccessor($obj)->get($obj);
    }

    /**
     * Gets the value of a static or instance <code>boolean</code> field.
     *
     * @param obj the object to extract the <code>boolean</code> value
     * from
     * @return boolean the value of the <code>boolean</code> field
     *
     * @exception IllegalAccessException    if the underlying field
     *              is inaccessible.
     * @exception IllegalArgumentException  if the specified object is not
     *              an instance of the class or interface declaring the
     *              underlying field (or a subclass or implementor
     *              thereof), or if the field value cannot be
     *              converted to the type <code>boolean</code> by a
     *              widening conversion.
     * @exception NullPointerException      if the specified object is null
     *              and the field is an instance field.
     * @exception ExceptionInInitializerError if the initialization provoked
     *              by this method fails.
     * @see       Field#get
     */
    public function getBoolean(Object $obj)
	//throws IllegalArgumentException, IllegalAccessException
    {
        //return getFieldAccessor(obj).getBoolean(obj);
    }

    /**
     * Gets the value of a static or instance <code>byte</code> field.
     *
     * @param obj the object to extract the <code>byte</code> value
     * from
     * @return integer the value of the <code>byte</code> field
     *
     * @exception IllegalAccessException    if the underlying field
     *              is inaccessible.
     * @exception IllegalArgumentException  if the specified object is not
     *              an instance of the class or interface declaring the
     *              underlying field (or a subclass or implementor
     *              thereof), or if the field value cannot be
     *              converted to the type <code>byte</code> by a
     *              widening conversion.
     * @exception NullPointerException      if the specified object is null
     *              and the field is an instance field.
     * @exception ExceptionInInitializerError if the initialization provoked
     *              by this method fails.
     * @see       Field#get
     */
    public function getByte(Object $obj)
	//throws IllegalArgumentException, IllegalAccessException
    {
        //return getFieldAccessor(obj).getByte(obj);
    }

    /**
     * Gets the value of a static or instance field of type
     * <code>char</code> or of another primitive type convertible to
     * type <code>char</code> via a widening conversion.
     *
     * @param obj the object to extract the <code>char</code> value
     * from
     * @return string the value of the field converted to type <code>char</code>
     *
     * @exception IllegalAccessException    if the underlying field
     *              is inaccessible.
     * @exception IllegalArgumentException  if the specified object is not
     *              an instance of the class or interface declaring the
     *              underlying field (or a subclass or implementor
     *              thereof), or if the field value cannot be
     *              converted to the type <code>char</code> by a
     *              widening conversion.
     * @exception NullPointerException      if the specified object is null
     *              and the field is an instance field.
     * @exception ExceptionInInitializerError if the initialization provoked
     *              by this method fails.
     * @see Field#get
     */
    public function getChar(Object $obj)
	//throws IllegalArgumentException, IllegalAccessException
    {
        //return getFieldAccessor(obj).getChar(obj);
    }

    /**
     * Gets the value of a static or instance field of type
     * <code>short</code> or of another primitive type convertible to
     * type <code>short</code> via a widening conversion.
     *
     * @param obj the object to extract the <code>short</code> value
     * from
     * @return integer the value of the field converted to type <code>short</code>
     *
     * @exception IllegalAccessException    if the underlying field
     *              is inaccessible.
     * @exception IllegalArgumentException  if the specified object is not
     *              an instance of the class or interface declaring the
     *              underlying field (or a subclass or implementor
     *              thereof), or if the field value cannot be
     *              converted to the type <code>short</code> by a
     *              widening conversion.
     * @exception NullPointerException      if the specified object is null
     *              and the field is an instance field.
     * @exception ExceptionInInitializerError if the initialization provoked
     *              by this method fails.
     * @see       Field#get
     */
    public function getShort(Object $obj)
	//throws IllegalArgumentException, IllegalAccessException
    {
        //return getFieldAccessor(obj).getShort(obj);
    }

    /**
     * Gets the value of a static or instance field of type
     * <code>int</code> or of another primitive type convertible to
     * type <code>int</code> via a widening conversion.
     *
     * @param obj the object to extract the <code>int</code> value
     * from
     * @return integer the value of the field converted to type <code>int</code>
     *
     * @exception IllegalAccessException    if the underlying field
     *              is inaccessible.
     * @exception IllegalArgumentException  if the specified object is not
     *              an instance of the class or interface declaring the
     *              underlying field (or a subclass or implementor
     *              thereof), or if the field value cannot be
     *              converted to the type <code>int</code> by a
     *              widening conversion.
     * @exception NullPointerException      if the specified object is null
     *              and the field is an instance field.
     * @exception ExceptionInInitializerError if the initialization provoked
     *              by this method fails.
     * @see       Field#get
     */
    public function getInt(Object $obj)
	//throws IllegalArgumentException, IllegalAccessException
    {
        //return getFieldAccessor(obj).getInt(obj);
    }

    /**
     * Gets the value of a static or instance field of type
     * <code>long</code> or of another primitive type convertible to
     * type <code>long</code> via a widening conversion.
     *
     * @param obj the object to extract the <code>long</code> value
     * from
     * @return the value of the field converted to type <code>long</code>
     *
     * @exception IllegalAccessException    if the underlying field
     *              is inaccessible.
     * @exception IllegalArgumentException  if the specified object is not
     *              an instance of the class or interface declaring the
     *              underlying field (or a subclass or implementor
     *              thereof), or if the field value cannot be
     *              converted to the type <code>long</code> by a
     *              widening conversion.
     * @exception NullPointerException      if the specified object is null
     *              and the field is an instance field.
     * @exception ExceptionInInitializerError if the initialization provoked
     *              by this method fails.
     * @see       Field#get
     */
    public function getLong(Object $obj)
	//throws IllegalArgumentException, IllegalAccessException
    {
        //return getFieldAccessor(obj).getLong(obj);
    }

    /**
     * Gets the value of a static or instance field of type
     * <code>float</code> or of another primitive type convertible to
     * type <code>float</code> via a widening conversion.
     *
     * @param obj the object to extract the <code>float</code> value
     * from
     * @return the value of the field converted to type <code>float</code>
     *
     * @exception IllegalAccessException    if the underlying field
     *              is inaccessible.
     * @exception IllegalArgumentException  if the specified object is not
     *              an instance of the class or interface declaring the
     *              underlying field (or a subclass or implementor
     *              thereof), or if the field value cannot be
     *              converted to the type <code>float</code> by a
     *              widening conversion.
     * @exception NullPointerException      if the specified object is null
     *              and the field is an instance field.
     * @exception ExceptionInInitializerError if the initialization provoked
     *              by this method fails.
     * @see Field#get
     */
    public function getFloat(Object $obj)
	//throws IllegalArgumentException, IllegalAccessException
    {
        //return getFieldAccessor(obj).getFloat(obj);
    }

    /**
     * Gets the value of a static or instance field of type
     * <code>double</code> or of another primitive type convertible to
     * type <code>double</code> via a widening conversion.
     *
     * @param obj the object to extract the <code>double</code> value
     * from
     * @return the value of the field converted to type <code>double</code>
     *
     * @exception IllegalAccessException    if the underlying field
     *              is inaccessible.
     * @exception IllegalArgumentException  if the specified object is not
     *              an instance of the class or interface declaring the
     *              underlying field (or a subclass or implementor
     *              thereof), or if the field value cannot be
     *              converted to the type <code>double</code> by a
     *              widening conversion.
     * @exception NullPointerException      if the specified object is null
     *              and the field is an instance field.
     * @exception ExceptionInInitializerError if the initialization provoked
     *              by this method fails.
     * @see       Field#get
     */
    public function getDouble(Object $obj)
	//throws IllegalArgumentException, IllegalAccessException
    {
        //return getFieldAccessor(obj).getDouble(obj);
    }

    /**
     * Sets the field represented by this <code>Field</code> object on the
     * specified object argument to the specified new value. The new
     * value is automatically unwrapped if the underlying field has a
     * primitive type.
     *
     * <p>The operation proceeds as follows:
     *
     * <p>If the underlying field is static, the <code>obj</code> argument is
     * ignored; it may be null.
     *
     * <p>Otherwise the underlying field is an instance field.  If the
     * specified object argument is null, the method throws a
     * <code>NullPointerException</code>.  If the specified object argument is not
     * an instance of the class or interface declaring the underlying
     * field, the method throws an <code>IllegalArgumentException</code>.
     *
     * <p>If this <code>Field</code> object enforces Java language access control, and
     * the underlying field is inaccessible, the method throws an
     * <code>IllegalAccessException</code>.
     *
     * <p>If the underlying field is final, the method throws an
     * <code>IllegalAccessException</code> unless
     * <code>setAccessible(true)</code> has succeeded for this field
     * and this field is non-static. Setting a final field in this way
     * is meaningful only during deserialization or reconstruction of
     * instances of classes with blank final fields, before they are
     * made available for access by other parts of a program. Use in
     * any other context may have unpredictable effects, including cases
     * in which other parts of a program continue to use the original
     * value of this field.
     *
     * <p>If the underlying field is of a primitive type, an unwrapping
     * conversion is attempted to convert the new value to a value of
     * a primitive type.  If this attempt fails, the method throws an
     * <code>IllegalArgumentException</code>.
     *
     * <p>If, after possible unwrapping, the new value cannot be
     * converted to the type of the underlying field by an identity or
     * widening conversion, the method throws an
     * <code>IllegalArgumentException</code>.
     *
     * <p>If the underlying field is static, the class that declared the
     * field is initialized if it has not already been initialized.
     *
     * <p>The field is set to the possibly unwrapped and widened new value.
     *
     * <p>If the field is hidden in the type of <code>obj</code>,
     * the field's value is set according to the preceding rules.
     *
     * @param obj the object whose field should be modified
     * @param value the new value for the field of <code>obj</code>
     * being modified
     *
     * @exception IllegalAccessException    if the underlying field
     *              is inaccessible.
     * @exception IllegalArgumentException  if the specified object is not an
     *              instance of the class or interface declaring the underlying
     *              field (or a subclass or implementor thereof),
     *              or if an unwrapping conversion fails.
     * @exception NullPointerException      if the specified object is null
     *              and the field is an instance field.
     * @exception ExceptionInInitializerError if the initialization provoked
     *              by this method fails.
     */
    public function set(Object $obj, Object $value)
	//throws IllegalArgumentException, IllegalAccessException
    {
        //getFieldAccessor(obj).set(obj, value);
    }

    /**
     * Sets the value of a field as a <code>boolean</code> on the specified object.
     * This method is equivalent to
     * <code>set(obj, zObj)</code>,
     * where <code>zObj</code> is a <code>Boolean</code> object and
     * <code>zObj.booleanValue() == z</code>.
     *
     * @param obj the object whose field should be modified
     * @param z   the new value for the field of <code>obj</code>
     * being modified
     *
     * @exception IllegalAccessException    if the underlying field
     *              is inaccessible.
     * @exception IllegalArgumentException  if the specified object is not an
     *              instance of the class or interface declaring the underlying
     *              field (or a subclass or implementor thereof),
     *              or if an unwrapping conversion fails.
     * @exception NullPointerException      if the specified object is null
     *              and the field is an instance field.
     * @exception ExceptionInInitializerError if the initialization provoked
     *              by this method fails.
     * @see       Field#set
     */
    public function setBoolean(Object $obj, $z)
	//throws IllegalArgumentException, IllegalAccessException
    {
        //getFieldAccessor(obj).setBoolean(obj, z);
    }

    /**
     * Sets the value of a field as a <code>byte</code> on the specified object.
     * This method is equivalent to
     * <code>set(obj, bObj)</code>,
     * where <code>bObj</code> is a <code>Byte</code> object and
     * <code>bObj.byteValue() == b</code>.
     *
     * @param obj the object whose field should be modified
     * @param b   the new value for the field of <code>obj</code>
     * being modified
     *
     * @exception IllegalAccessException    if the underlying field
     *              is inaccessible.
     * @exception IllegalArgumentException  if the specified object is not an
     *              instance of the class or interface declaring the underlying
     *              field (or a subclass or implementor thereof),
     *              or if an unwrapping conversion fails.
     * @exception NullPointerException      if the specified object is null
     *              and the field is an instance field.
     * @exception ExceptionInInitializerError if the initialization provoked
     *              by this method fails.
     * @see       Field#set
     */
    public function setByte(Object $obj, $b)
	//throws IllegalArgumentException, IllegalAccessException
    {
        //getFieldAccessor(obj).setByte(obj, b);
    }

    /**
     * Sets the value of a field as a <code>char</code> on the specified object.
     * This method is equivalent to
     * <code>set(obj, cObj)</code>,
     * where <code>cObj</code> is a <code>Character</code> object and
     * <code>cObj.charValue() == c</code>.
     *
     * @param obj the object whose field should be modified
     * @param c   the new value for the field of <code>obj</code>
     * being modified
     *
     * @exception IllegalAccessException    if the underlying field
     *              is inaccessible.
     * @exception IllegalArgumentException  if the specified object is not an
     *              instance of the class or interface declaring the underlying
     *              field (or a subclass or implementor thereof),
     *              or if an unwrapping conversion fails.
     * @exception NullPointerException      if the specified object is null
     *              and the field is an instance field.
     * @exception ExceptionInInitializerError if the initialization provoked
     *              by this method fails.
     * @see       Field#set
     */
    public function setChar(Object $obj, $c)
	//throws IllegalArgumentException, IllegalAccessException
    {
        //getFieldAccessor(obj).setChar(obj, c);
    }

    /**
     * Sets the value of a field as a <code>short</code> on the specified object.
     * This method is equivalent to
     * <code>set(obj, sObj)</code>,
     * where <code>sObj</code> is a <code>Short</code> object and
     * <code>sObj.shortValue() == s</code>.
     *
     * @param obj the object whose field should be modified
     * @param s   the new value for the field of <code>obj</code>
     * being modified
     *
     * @exception IllegalAccessException    if the underlying field
     *              is inaccessible.
     * @exception IllegalArgumentException  if the specified object is not an
     *              instance of the class or interface declaring the underlying
     *              field (or a subclass or implementor thereof),
     *              or if an unwrapping conversion fails.
     * @exception NullPointerException      if the specified object is null
     *              and the field is an instance field.
     * @exception ExceptionInInitializerError if the initialization provoked
     *              by this method fails.
     * @see       Field#set
     */
    public function setShort(Object $obj, $s)
	//throws IllegalArgumentException, IllegalAccessException
    {
        //getFieldAccessor(obj).setShort(obj, s);
    }

    /**
     * Sets the value of a field as an <code>int</code> on the specified object.
     * This method is equivalent to
     * <code>set(obj, iObj)</code>,
     * where <code>iObj</code> is a <code>Integer</code> object and
     * <code>iObj.intValue() == i</code>.
     *
     * @param obj the object whose field should be modified
     * @param i   the new value for the field of <code>obj</code>
     * being modified
     *
     * @exception IllegalAccessException    if the underlying field
     *              is inaccessible.
     * @exception IllegalArgumentException  if the specified object is not an
     *              instance of the class or interface declaring the underlying
     *              field (or a subclass or implementor thereof),
     *              or if an unwrapping conversion fails.
     * @exception NullPointerException      if the specified object is null
     *              and the field is an instance field.
     * @exception ExceptionInInitializerError if the initialization provoked
     *              by this method fails.
     * @see       Field#set
     */
    public function setInt(Object $obj, $i)
	//throws IllegalArgumentException, IllegalAccessException
    {
        //getFieldAccessor(obj).setInt(obj, i);
    }

    /**
     * Sets the value of a field as a <code>long</code> on the specified object.
     * This method is equivalent to
     * <code>set(obj, lObj)</code>,
     * where <code>lObj</code> is a <code>Long</code> object and
     * <code>lObj.longValue() == l</code>.
     *
     * @param obj the object whose field should be modified
     * @param l   the new value for the field of <code>obj</code>
     * being modified
     *
     * @exception IllegalAccessException    if the underlying field
     *              is inaccessible.
     * @exception IllegalArgumentException  if the specified object is not an
     *              instance of the class or interface declaring the underlying
     *              field (or a subclass or implementor thereof),
     *              or if an unwrapping conversion fails.
     * @exception NullPointerException      if the specified object is null
     *              and the field is an instance field.
     * @exception ExceptionInInitializerError if the initialization provoked
     *              by this method fails.
     * @see       Field#set
     */
    public function setLong(Object $obj, $l)
	//throws IllegalArgumentException, IllegalAccessException
    {
        //getFieldAccessor(obj).setLong(obj, l);
    }

    /**
     * Sets the value of a field as a <code>float</code> on the specified object.
     * This method is equivalent to
     * <code>set(obj, fObj)</code>,
     * where <code>fObj</code> is a <code>Float</code> object and
     * <code>fObj.floatValue() == f</code>.
     *
     * @param obj the object whose field should be modified
     * @param f   the new value for the field of <code>obj</code>
     * being modified
     *
     * @exception IllegalAccessException    if the underlying field
     *              is inaccessible.
     * @exception IllegalArgumentException  if the specified object is not an
     *              instance of the class or interface declaring the underlying
     *              field (or a subclass or implementor thereof),
     *              or if an unwrapping conversion fails.
     * @exception NullPointerException      if the specified object is null
     *              and the field is an instance field.
     * @exception ExceptionInInitializerError if the initialization provoked
     *              by this method fails.
     * @see       Field#set
     */
    public function setFloat(Object $obj, $f)
	//throws IllegalArgumentException, IllegalAccessException
    {
        //getFieldAccessor(obj).setFloat(obj, f);
    }

    /**
     * Sets the value of a field as a <code>double</code> on the specified object.
     * This method is equivalent to
     * <code>set(obj, dObj)</code>,
     * where <code>dObj</code> is a <code>Double</code> object and
     * <code>dObj.doubleValue() == d</code>.
     *
     * @param obj the object whose field should be modified
     * @param d   the new value for the field of <code>obj</code>
     * being modified
     *
     * @exception IllegalAccessException    if the underlying field
     *              is inaccessible.
     * @exception IllegalArgumentException  if the specified object is not an
     *              instance of the class or interface declaring the underlying
     *              field (or a subclass or implementor thereof),
     *              or if an unwrapping conversion fails.
     * @exception NullPointerException      if the specified object is null
     *              and the field is an instance field.
     * @exception ExceptionInInitializerError if the initialization provoked
     *              by this method fails.
     * @see       Field#set
     */
    public function setDouble(Object $obj, $d)
	//throws IllegalArgumentException, IllegalAccessException
    {
        //getFieldAccessor(obj).setDouble(obj, d);
    }

    /**
     *
     * @return array
     */
    public function getAnnotations(){
        $annotations = array();

        if (preg_match_all('/@(?P<name>[A-Za-z_-]+)(?:[ \t]+(?P<value>.*?))?[ \t]*\r?$/m', $this->property->getDocComment(), $matches)) {
            $numMatches = count($matches[0]);

            for ($i = 0; $i < $numMatches; ++$i) {
                $annotations[$matches['name'][$i]][] = $matches['value'][$i];
            }
        }

        return $annotations;
    }

    /**
     *
     * @return boolean
     */
    public function hasAnnotations() {
        return count($this->getAnnotations()) != 0;
    }
}

?>
