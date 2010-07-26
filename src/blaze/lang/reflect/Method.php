<?php
namespace blaze\lang\reflect;
use blaze\lang\Object,
    blaze\lang\Exception;

/**
 * The method which is defined within a class.
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @author  Christian Beikov
 * @todo    Methods are not implemented and nothing is documented.
 */
class Method extends Object{
    private $reflectionMethod;

    public function __construct(\ReflectionMethod $method){
        //parent::__construct();
        $this->reflectionMethod = $method;
    }

    public static function export ($class, $name, $return) {}

    /**
     * Returns a string describing this <code>Method</code>.  The string is
     * formatted as the method access modifiers, if any, followed by
     * the method return type, followed by a space, followed by the
     * class declaring the method, followed by a period, followed by
     * the method name, followed by a parenthesized, comma-separated
     * list of the method's formal parameter types. If the method
     * throws checked exceptions, the parameter list is followed by a
     * space, followed by the word throws followed by a
     * comma-separated list of the thrown exception types.
     * For example:
     * <pre>
     *    public boolean java.lang.Object.equals(java.lang.Object)
     * </pre>
     *
     * <p>The access modifiers are placed in canonical order as
     * specified by "The Java Language Specification".  This is
     * <tt>public</tt>, <tt>protected</tt> or <tt>private</tt> first,
     * and then other modifiers in the following order:
     * <tt>abstract</tt>, <tt>static</tt>, <tt>final</tt>,
     * <tt>synchronized</tt>, <tt>native</tt>.
     */
	public function __toString () {
        return $this->reflectionMethod->__toString();
//        try {
//	    StringBuffer sb = new StringBuffer();
//	    int mod = getModifiers() & LANGUAGE_MODIFIERS;
//	    if (mod != 0) {
//		sb.append(Modifier.toString(mod) + " ");
//	    }
//	    sb.append(Field.getTypeName(getReturnType()) + " ");
//	    sb.append(Field.getTypeName(getDeclaringClass()) + ".");
//	    sb.append(getName() + "(");
//	    Class[] params = parameterTypes; // avoid clone
//	    for (int j = 0; j < params.length; j++) {
//		sb.append(Field.getTypeName(params[j]));
//		if (j < (params.length - 1))
//		    sb.append(",");
//	    }
//	    sb.append(")");
//	    Class[] exceptions = exceptionTypes; // avoid clone
//	    if (exceptions.length > 0) {
//		sb.append(" throws ");
//		for (int k = 0; k < exceptions.length; k++) {
//		    sb.append(exceptions[k].getName());
//		    if (k < (exceptions.length - 1))
//			sb.append(",");
//		}
//	    }
//	    return sb.toString();
//	} catch (Exception e) {
//	    return "<" + e + ">";
//	}
    }

    /**
     * Returns a string describing this <code>Method</code>, including
     * type parameters.  The string is formatted as the method access
     * modifiers, if any, followed by an angle-bracketed
     * comma-separated list of the method's type parameters, if any,
     * followed by the method's generic return type, followed by a
     * space, followed by the class declaring the method, followed by
     * a period, followed by the method name, followed by a
     * parenthesized, comma-separated list of the method's generic
     * formal parameter types. A space is used to separate access
     * modifiers from one another and from the type parameters or
     * return type.  If there are no type parameters, the type
     * parameter list is elided; if the type parameter list is
     * present, a space separates the list from the class name.  If
     * the method is declared to throw exceptions, the parameter list
     * is followed by a space, followed by the word throws followed by
     * a comma-separated list of the generic thrown exception types.
     * If there are no type parameters, the type parameter list is
     * elided.
     *
     * <p>The access modifiers are placed in canonical order as
     * specified by "The Java Language Specification".  This is
     * <tt>public</tt>, <tt>protected</tt> or <tt>private</tt> first,
     * and then other modifiers in the following order:
     * <tt>abstract</tt>, <tt>static</tt>, <tt>final</tt>,
     * <tt>synchronized</tt> <tt>native</tt>.
     *
     * @return a string describing this <code>Method</code>,
     * include type parameters
     *
     * @since 1.5
     */
    public function toGenericString() {
        throw new Exception('Not yet implemented');
    }

    /**
     * Returns <tt>true</tt> if this method is a bridge
     * method; returns <tt>false</tt> otherwise.
     *
     * @return true if and only if this method is a bridge
     * method as defined by the Java Language Specification.
     * @since 1.5
     */
    public function isBridge() {
        throw new Exception('Not yet implemented');
    }

    /**
     * Returns <tt>true</tt> if this method was declared to take
     * a variable number of arguments; returns <tt>false</tt>
     * otherwise.
     *
     * @return <tt>true</tt> if an only if this method was declared to
     * take a variable number of arguments.
     * @since 1.5
     */
    public function isVarArgs(){
        throw new Exception('Not yet implemented');
    }

    /**
     * Returns <tt>true</tt> if this method is a synthetic
     * method; returns <tt>false</tt> otherwise.
     *
     * @return true if and only if this method is a synthetic
     * method as defined by the Java Language Specification.
     * @since 1.5
     */
    public function isSynthetic(){
        throw new Exception('Not yet implemented');
    }

    public function isPublic () {
        return $this->reflectionMethod->isPublic();
    }

    public function isPrivate () {}

    public function isProtected () {}

    public function isAbstract () {}

    public function isFinal () {}

    public function isStatic () {}

    public function isConstructor () {}

    public function isDestructor () {}

    /**
     * Returns the Java language modifiers for the method represented
     * by this <code>Method</code> object, as an integer. The <code>Modifier</code> class should
     * be used to decode the modifiers.
     *
     * @see Modifier
     */
    public function getModifiers () {
        return $this->reflectionMethod->getModifiers();
    }

    /**
     * Invokes the underlying method represented by this <code>Method</code>
     * object, on the specified object with the specified parameters.
     * Individual parameters are automatically unwrapped to match
     * primitive formal parameters, and both primitive and reference
     * parameters are subject to method invocation conversions as
     * necessary.
     *
     * <p>If the underlying method is static, then the specified <code>obj</code>
     * argument is ignored. It may be null.
     *
     * <p>If the number of formal parameters required by the underlying method is
     * 0, the supplied <code>args</code> array may be of length 0 or null.
     *
     * <p>If the underlying method is an instance method, it is invoked
     * using dynamic method lookup as documented in The Java Language
     * Specification, Second Edition, section 15.12.4.4; in particular,
     * overriding based on the runtime type of the target object will occur.
     *
     * <p>If the underlying method is static, the class that declared
     * the method is initialized if it has not already been initialized.
     *
     * <p>If the method completes normally, the value it returns is
     * returned to the caller of invoke; if the value has a primitive
     * type, it is first appropriately wrapped in an object. However,
     * if the value has the type of an array of a primitive type, the
     * elements of the array are <i>not</i> wrapped in objects; in
     * other words, an array of primitive type is returned.  If the
     * underlying method return type is void, the invocation returns
     * null.
     *
     * @param obj  the object the underlying method is invoked from
     * @param args the arguments used for the method call
     * @return the result of dispatching the method represented by
     * this object on <code>obj</code> with parameters
     * <code>args</code>
     *
     * @exception IllegalAccessException    if this <code>Method</code> object
     *              enforces Java language access control and the underlying
     *              method is inaccessible.
     * @exception IllegalArgumentException  if the method is an
     *              instance method and the specified object argument
     *              is not an instance of the class or interface
     *              declaring the underlying method (or of a subclass
     *              or implementor thereof); if the number of actual
     *              and formal parameters differ; if an unwrapping
     *              conversion for primitive arguments fails; or if,
     *              after possible unwrapping, a parameter value
     *              cannot be converted to the corresponding formal
     *              parameter type by a method invocation conversion.
     * @exception InvocationTargetException if the underlying method
     *              throws an exception.
     * @exception NullPointerException      if the specified object is null
     *              and the method is an instance method.
     * @exception ExceptionInInitializerError if the initialization
     * provoked by this method fails.
     */
    public function invoke ($obj, $args) {
        $args = func_get_args();
        array_shift($args);
        return $this->reflectionMethod->invokeArgs($obj, $args);
    }

    /**
	 * @param object
	 * @param args
	 */
    public function invokeArgs ($objectarray , $args) {
        return $this->reflectionMethod->invokeArgs($obj, $args);
    }

    /**
     * Returns the <code>Class</code> object representing the class or interface
     * that declares the method represented by this <code>Method</code> object.
     */
    public function getDeclaringClass () {
        return $this->reflectionMethod->getDeclaringClass();
    }

    public function getPrototype () {}

    public function inNamespace () {}

    public function isClosure () {}

    public function isDeprecated () {}

    public function isInternal () {}

    public function isUserDefined () {}

    public function getDocComment () {}

    public function getEndLine () {}

    public function getExtension () {}

    public function getExtensionName () {}

    public function getFileName () {}

    /**
     * Returns the name of the method represented by this <code>Method</code>
     * object, as a <code>String</code>.
     */
	public function getName () {
        return $this->reflectionMethod->getName();
    }

    /**
     * Returns an array of <tt>TypeVariable</tt> objects that represent the
     * type variables declared by the generic declaration represented by this
     * <tt>GenericDeclaration</tt> object, in declaration order.  Returns an
     * array of length 0 if the underlying generic declaration declares no type
     * variables.
     *
     * @return an array of <tt>TypeVariable</tt> objects that represent
     *     the type variables declared by this generic declaration
     * @throws GenericSignatureFormatError if the generic
     *     signature of this generic declaration does not conform to
     *     the format specified in the Java Virtual Machine Specification,
     *     3rd edition
     * @since 1.5
     */
    public function getTypeParameters(){
        throw new Exception('Not yet implemented');
    }

    /**
     * Returns a <code>Class</code> object that represents the formal return type
     * of the method represented by this <code>Method</code> object.
     * 
     * @return the return type for the method this object represents
     */
    public function getReturnType(){
        throw new Exception('Not yet implemented');
    }

    /**
     * Returns a <tt>Type</tt> object that represents the formal return
     * type of the method represented by this <tt>Method</tt> object.
     *
     * <p>If the return type is a parameterized type,
     * the <tt>Type</tt> object returned must accurately reflect
     * the actual type parameters used in the source code.
     *
     * <p>If the return type is a type variable or a parameterized type, it
     * is created. Otherwise, it is resolved.
     *
     * @return  a <tt>Type</tt> object that represents the formal return
     *     type of the underlying  method
     * @throws GenericSignatureFormatError
     *     if the generic method signature does not conform to the format
     *     specified in the Java Virtual Machine Specification, 3rd edition
     * @throws TypeNotPresentException if the underlying method's
     *     return type refers to a non-existent type declaration
     * @throws MalformedParameterizedTypeException if the
     *     underlying method's return typed refers to a parameterized
     *     type that cannot be instantiated for any reason
     * @since 1.5
     */
    public function getGenericReturnType(){
        throw new Exception('Not yet implemented');
    }

    /**
     * Returns an array of <code>Class</code> objects that represent the formal
     * parameter types, in declaration order, of the method
     * represented by this <code>Method</code> object.  Returns an array of length
     * 0 if the underlying method takes no parameters.
     *
     * @return the parameter types for the method this object
     * represents
     */
    public function getParameterTypes(){
        throw new Exception('Not yet implemented');
    }

    /**
     * Returns an array of <tt>Type</tt> objects that represent the formal
     * parameter types, in declaration order, of the method represented by
     * this <tt>Method</tt> object. Returns an array of length 0 if the
     * underlying method takes no parameters.
     *
     * <p>If a formal parameter type is a parameterized type,
     * the <tt>Type</tt> object returned for it must accurately reflect
     * the actual type parameters used in the source code.
     *
     * <p>If a formal parameter type is a type variable or a parameterized
     * type, it is created. Otherwise, it is resolved.
     *
     * @return an array of Types that represent the formal
     *     parameter types of the underlying method, in declaration order
     * @throws GenericSignatureFormatError
     *     if the generic method signature does not conform to the format
     *     specified in the Java Virtual Machine Specification, 3rd edition
     * @throws TypeNotPresentException if any of the parameter
     *     types of the underlying method refers to a non-existent type
     *     declaration
     * @throws MalformedParameterizedTypeException if any of
     *     the underlying method's parameter types refer to a parameterized
     *     type that cannot be instantiated for any reason
     * @since 1.5
     */
    public function getGenericParameterTypes(){
        throw new Exception('Not yet implemented');
    }

    /**
     * Returns an array of <code>Class</code> objects that represent
     * the types of the exceptions declared to be thrown
     * by the underlying method
     * represented by this <code>Method</code> object.  Returns an array of length
     * 0 if the method declares no exceptions in its <code>throws</code> clause.
     *
     * @return the exception types declared as being thrown by the
     * method this object represents
     */
    public function getExceptionTypes(){
        throw new Exception('Not yet implemented');
    }

    /**
     * Returns an array of <tt>Type</tt> objects that represent the
     * exceptions declared to be thrown by this <tt>Method</tt> object.
     * Returns an array of length 0 if the underlying method declares
     * no exceptions in its <tt>throws</tt> clause.
     *
     * <p>If an exception type is a parameterized type, the <tt>Type</tt>
     * object returned for it must accurately reflect the actual type
     * parameters used in the source code.
     *
     * <p>If an exception type is a type variable or a parameterized
     * type, it is created. Otherwise, it is resolved.
     *
     * @return an array of Types that represent the exception types
     *     thrown by the underlying method
     * @throws GenericSignatureFormatError
     *     if the generic method signature does not conform to the format
     *     specified in the Java Virtual Machine Specification, 3rd edition
     * @throws TypeNotPresentException if the underlying method's
     *     <tt>throws</tt> clause refers to a non-existent type declaration
     * @throws MalformedParameterizedTypeException if
     *     the underlying method's <tt>throws</tt> clause refers to a
     *     parameterized type that cannot be instantiated for any reason
     * @since 1.5
     */
    public function getGenericExceptionTypes(){
        throw new Exception('Not yet implemented');
    }

    public function getNamespaceName () {}

    public function getNumberOfParameters () {
        return $this->reflectionMethod->getNumberOfParameters();
    }

    public function getNumberOfRequiredParameters () {
        return $this->reflectionMethod->getNumberOfRequiredParameters();
    }

    public function getParameters () {}

    public function getShortName () {}

    public function getStartLine () {}

    public function getStaticVariables () {}

    public function returnsReference () {}

    
    /**
     *
     * @return array
     */
    public function getAnnotations(){
        $annotations = array();

        if (preg_match_all('/@(?P<name>[A-Za-z_-]+)(?:[ \t]+(?P<value>.*?))?[ \t]*\r?$/m', $this->reflectionMethod->getDocComment(), $matches)) {
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