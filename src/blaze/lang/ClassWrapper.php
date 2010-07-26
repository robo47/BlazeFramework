<?php
namespace blaze\lang;
use \ReflectionClass,
	blaze\util\ArrayObject,
	blaze\lang\reflect\Method,
	blaze\lang\reflect\Field,
	blaze\io\Serializable;

/**
 * Instances of the class ClassWrapper represent classes, interfaces and enumerations which are classes too.
 * Native datatypes can only be 
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @version $Revision$
 * @author  Christian Beikov
 * @todo    Documentations is missing
 */
final class ClassWrapper extends Object implements Serializable{
    private $reflectionClass;

    private function __construct(ReflectionClass $class){
        //parent::__construct();
        $this->reflectionClass = $class;
    }

    /**
     * Converts the object to a string. The string representation is the
     * string "class" or "interface", followed by a space, and then by the
     * fully qualified name of the class in the format returned by
     * <code>getName</code>.  If this <code>Class</code> object represents a
     * primitive type, this method returns the name of the primitive type.  If
     * this <code>Class</code> object represents void this method returns
     * "void".
     *
     * @return string a string representation of this class object.
     */
    public function __toString(){
        return ($this->isInterface() ? "interface " : ($this->isPrimitive() ? "" : "class ")). $this->getName();
    }

    /**
     * Returns the <code>Class</code> object associated with the class or
     * interface with the given string name.  Invoking this method is
     * equivalent to:
     *
     * <blockquote><pre>
     *  Class.forName(className, true, currentLoader)
     * </pre></blockquote>
     *
     * where <code>currentLoader</code> denotes the defining class loader of
     * the current class.
     *
     * <p> For example, the following code fragment returns the
     * runtime <code>Class</code> descriptor for the class named
     * <code>java.lang.Thread</code>:
     *
     * <blockquote><pre>
     *   Class&nbsp;t&nbsp;= Class.forName("java.lang.Thread")
     * </pre></blockquote>
     * <p>
     * A call to <tt>forName("X")</tt> causes the class named
     * <tt>X</tt> to be initialized.
     *
     * @param blaze\lang\String|string $className   the fully qualified name of the desired class.
     * @return blaze\lang\ClassWrapper   ClassWrapper the <code>Class</code> object for the class with the
     *             specified name.
     * @exception LinkageError if the linkage fails
     * @exception ExceptionInInitializerError if the initialization provoked
     *            by this method fails
     * @exception ClassNotFoundException if the class cannot be located
     */
    public static function forName($className){
        if($className instanceof String){
            $reflection = new ReflectionClass($className->toNative());
            
            if(!$reflection->isSubclassOf('blaze\lang\Object') && $reflection->getName() != 'blaze\lang\Object')
                throw new IllegalArgumentException('Reflection only works for classes which extend blaze\lang\Object');
            return new self($reflection);
        }else{
            if(is_string($className) || is_object($className)){
                $reflection = new ReflectionClass($className);

                if(!$reflection->isSubclassOf('blaze\lang\Object') && $reflection->getName() != 'blaze\lang\Object')
                    throw new IllegalArgumentException('Reflection only works for classes which extend blaze\lang\Object');
                return new self($reflection);
            }
        }
        
        return null;
    }

    /**
     * Creates a new instance of the class represented by this <tt>Class</tt>
     * object.  The class is instantiated as if by a <code>new</code>
     * expression with an empty argument list.  The class is initialized if it
     * has not already been initialized.
     *
     * <p>Note that this method propagates any exception thrown by the
     * nullary constructor, including a checked exception.  Use of
     * this method effectively bypasses the compile-time exception
     * checking that would otherwise be performed by the compiler.
     * The {@link
     * java.lang.reflect.Constructor#newInstance(java.lang.Object...)
     * Constructor.newInstance} method avoids this problem by wrapping
     * any exception thrown by the constructor in a (checked) {@link
     * java.lang.reflect.InvocationTargetException}.
     *
     * @return     a newly allocated instance of the class represented by this
     *             object.
     * @exception  IllegalAccessException  if the class or its nullary
     *               constructor is not accessible.
     * @exception  InstantiationException
     *               if this <code>Class</code> represents an abstract class,
     *               an interface, an array class, a primitive type, or void;
     *               or if the class has no nullary constructor;
     *               or if the instantiation fails for some other reason.
     * @exception  ExceptionInInitializerError if the initialization
     *               provoked by this method fails.
     * @exception  SecurityException
     *             If a security manager, <i>s</i>, is present and any of the
     *             following conditions is met:
     *
     *             <ul>
     *
     *             <li> invocation of
     *             <tt>{@link SecurityManager#checkMemberAccess
     *             s.checkMemberAccess(this, Member.PUBLIC)}</tt> denies
     *             creation of new instances of this class
     *
     *             <li> the caller's class loader is not the same as or an
     *             ancestor of the class loader for the current class and
     *             invocation of <tt>{@link SecurityManager#checkPackageAccess
     *             s.checkPackageAccess()}</tt> denies access to the package
     *             of this class
     *
     *             </ul>
     *
     */
    public function newInstance($args = null){
        if(is_array($args))
            return $this->reflectionClass->newInstance($args);
        else
            return $this->reflectionClass->newInstance(null);
    }

    /**
     * Determines if the specified <code>Object</code> is assignment-compatible
     * with the object represented by this <code>Class</code>.  This method is
     * the dynamic equivalent of the Java language <code>instanceof</code>
     * operator. The method returns <code>true</code> if the specified
     * <code>Object</code> argument is non-null and can be cast to the
     * reference type represented by this <code>Class</code> object without
     * raising a <code>ClassCastException.</code> It returns <code>false</code>
     * otherwise.
     *
     * <p> Specifically, if this <code>Class</code> object represents a
     * declared class, this method returns <code>true</code> if the specified
     * <code>Object</code> argument is an instance of the represented class (or
     * of any of its subclasses); it returns <code>false</code> otherwise. If
     * this <code>Class</code> object represents an array class, this method
     * returns <code>true</code> if the specified <code>Object</code> argument
     * can be converted to an object of the array class by an identity
     * conversion or by a widening reference conversion; it returns
     * <code>false</code> otherwise. If this <code>Class</code> object
     * represents an interface, this method returns <code>true</code> if the
     * class or any superclass of the specified <code>Object</code> argument
     * implements this interface; it returns <code>false</code> otherwise. If
     * this <code>Class</code> object represents a primitive type, this method
     * returns <code>false</code>.
     *
     * @param   obj the object to check
     * @return boolean true if <code>obj</code> is an instance of this class
     *
     * @since JDK1.1
     */
    public function isInstance(Object $obj){
        return $this->reflectionClass->isInstance($obj);
    }

    /**
     * Determines if the specified <code>Class</code> object represents an
     * interface type.
     *
     * @return  <code>true</code> if this object represents an interface;
     *          <code>false</code> otherwise.
     */
    public function isInterface(){
        return $this->reflectionClass->isInterface();
    }

    /**
     * Determines if this <code>Class</code> object represents an array class.
     *
     * @return  <code>true</code> if this object represents an array class;
     *          <code>false</code> otherwise.
     * @since   JDK1.1
     */
    public function isArray(){
        return $this->reflectionClass->getName() instanceof \ArrayObject;
    }

    /**
     * Determines if the specified <code>Class</code> object represents a
     * primitive type.
     *
     * <p> There are nine predefined <code>Class</code> objects to represent
     * the eight primitive types and void.  These are created by the Java
     * Virtual Machine, and have the same names as the primitive types that
     * they represent, namely <code>boolean</code>, <code>byte</code>,
     * <code>char</code>, <code>short</code>, <code>int</code>,
     * <code>long</code>, <code>float</code>, and <code>double</code>.
     *
     * <p> These objects may only be accessed via the following public static
     * final variables, and are the only <code>Class</code> objects for which
     * this method returns <code>true</code>.
     *
     * @return true if and only if this class represents a primitive type
     *
     * @see     java.lang.Boolean#TYPE
     * @see     java.lang.Character#TYPE
     * @see     java.lang.Byte#TYPE
     * @see     java.lang.Short#TYPE
     * @see     java.lang.Integer#TYPE
     * @see     java.lang.Long#TYPE
     * @see     java.lang.Float#TYPE
     * @see     java.lang.Double#TYPE
     * @see     java.lang.Void#TYPE
     * @since JDK1.1
     */
    public function isPrimitive(){
        return false;
    }

    /**
     * Returns <tt>true</tt> if this class is a synthetic class;
     * returns <tt>false</tt> otherwise.
     * @return <tt>true</tt> if and only if this class is a synthetic class as
     *         defined by the Java Language Specification.
     * @since 1.5
     */
    public function isSynthetic(){
        return $this->reflectionClass->isUserDefined();
    }

    /**
     * Returns the  name of the entity (class, interface, array class,
     * primitive type, or void) represented by this <tt>Class</tt> object,
     * as a <tt>String</tt>.
     *
     * <p> If this class object represents a reference type that is not an
     * array type then the binary name of the class is returned, as specified
     * by the Java Language Specification, Second Edition.
     *
     * <p> If this class object represents a primitive type or void, then the
     * name returned is a <tt>String</tt> equal to the Java language
     * keyword corresponding to the primitive type or void.
     *
     * <p> If this class object represents a class of arrays, then the internal
     * form of the name consists of the name of the element type preceded by
     * one or more '<tt>[</tt>' characters representing the depth of the array
     * nesting.  The encoding of element type names is as follows:
     *
     * <blockquote><table summary="Element types and encodings">
     * <tr><th> Element Type <th> &nbsp;&nbsp;&nbsp; <th> Encoding
     * <tr><td> boolean      <td> &nbsp;&nbsp;&nbsp; <td align=center> Z
     * <tr><td> byte         <td> &nbsp;&nbsp;&nbsp; <td align=center> B
     * <tr><td> char         <td> &nbsp;&nbsp;&nbsp; <td align=center> C
     * <tr><td> class or interface
     *                       <td> &nbsp;&nbsp;&nbsp; <td align=center> L<i>classname</i>;
     * <tr><td> double       <td> &nbsp;&nbsp;&nbsp; <td align=center> D
     * <tr><td> float        <td> &nbsp;&nbsp;&nbsp; <td align=center> F
     * <tr><td> int          <td> &nbsp;&nbsp;&nbsp; <td align=center> I
     * <tr><td> long         <td> &nbsp;&nbsp;&nbsp; <td align=center> J
     * <tr><td> short        <td> &nbsp;&nbsp;&nbsp; <td align=center> S
     * </table></blockquote>
     *
     * <p> The class or interface name <i>classname</i> is the binary name of
     * the class specified above.
     *
     * <p> Examples:
     * <blockquote><pre>
     * String.class.getName()
     *     returns "java.lang.String"
     * byte.class.getName()
     *     returns "byte"
     * (new Object[3]).getClass().getName()
     *     returns "[Ljava.lang.Object;"
     * (new int[3][4][5][6][7][8][9]).getClass().getName()
     *     returns "[[[[[[[I"
     * </pre></blockquote>
     *
     * @return  the name of the class or interface
     *          represented by this object.
     */
    public function getName(){
        return $this->reflectionClass->getName();
    }

    /**
     * Returns the class loader for the class.  Some implementations may use
     * null to represent the bootstrap class loader. This method will return
     * null in such implementations if this class was loaded by the bootstrap
     * class loader.
     *
     * <p> If a security manager is present, and the caller's class loader is
     * not null and the caller's class loader is not the same as or an ancestor of
     * the class loader for the class whose class loader is requested, then
     * this method calls the security manager's <code>checkPermission</code>
     * method with a <code>RuntimePermission("getClassLoader")</code>
     * permission to ensure it's ok to access the class loader for the class.
     *
     * <p>If this object
     * represents a primitive type or void, null is returned.
     *
     * @return blaze\lang\ClassLoader the class loader that loaded the class or interface
     *          represented by this object.
     * @throws SecurityException
     *    if a security manager exists and its
     *    <code>checkPermission</code> method denies
     *    access to the class loader for the class.
     * @see java.lang.ClassLoader
     * @see SecurityManager#checkPermission
     * @see java.lang.RuntimePermission
     */
    public function getClassLoader(){
        return ClassLoader::getInstance();
    }

    /**
     * Returns the <code>Class</code> representing the superclass of the entity
     * (class, interface, primitive type or void) represented by this
     * <code>Class</code>.  If this <code>Class</code> represents either the
     * <code>Object</code> class, an interface, a primitive type, or void, then
     * null is returned.  If this object represents an array class then the
     * <code>Class</code> object representing the <code>Object</code> class is
     * returned.
     *
     * @return the superclass of the class represented by this object.
     */
    public function getSuperclass(){
        return new self($this->reflectionClass->getParentClass());
    }

    /**
     * Gets the package for this class.  The class loader of this class is used
     * to find the package.  If the class was loaded by the bootstrap class
     * loader the set of packages loaded from CLASSPATH is searched to find the
     * package of the class. Null is returned if no package object was created
     * by the class loader of this class.
     *
     * <p> Packages have attributes for versions and specifications only if the
     * information was defined in the manifests that accompany the classes, and
     * if the class loader created the package instance with the attributes
     * from the manifest.
     *
     * @return the package of the class, or null if no package
     *         information is available from the archive or codebase.
     */
    public function getPackage() {
        return $this->reflectionClass->getNamespaceName();
    }

    /**
     * Determines the interfaces implemented by the class or interface
     * represented by this object.
     *
     * <p> If this object represents a class, the return value is an array
     * containing objects representing all interfaces implemented by the
     * class. The order of the interface objects in the array corresponds to
     * the order of the interface names in the <code>implements</code> clause
     * of the declaration of the class represented by this object. For
     * example, given the declaration:
     * <blockquote><pre>
     * class Shimmer implements FloorWax, DessertTopping { ... }
     * </pre></blockquote>
     * suppose the value of <code>s</code> is an instance of
     * <code>Shimmer</code>; the value of the expression:
     * <blockquote><pre>
     * s.getClass().getInterfaces()[0]
     * </pre></blockquote>
     * is the <code>Class</code> object that represents interface
     * <code>FloorWax</code>; and the value of:
     * <blockquote><pre>
     * s.getClass().getInterfaces()[1]
     * </pre></blockquote>
     * is the <code>Class</code> object that represents interface
     * <code>DessertTopping</code>.
     *
     * <p> If this object represents an interface, the array contains objects
     * representing all interfaces extended by the interface. The order of the
     * interface objects in the array corresponds to the order of the interface
     * names in the <code>extends</code> clause of the declaration of the
     * interface represented by this object.
     *
     * <p> If this object represents a class or interface that implements no
     * interfaces, the method returns an array of length 0.
     *
     * <p> If this object represents a primitive type or void, the method
     * returns an array of length 0.
     *
     * @return an array of interfaces implemented by this class.
     */
    public function getInterfaces(){
        return $this->reflectionClass->getInterfaces();
    }

    /**
     * Returns the Java language modifiers for this class or interface, encoded
     * in an integer. The modifiers consist of the Java Virtual Machine's
     * constants for <code>public</code>, <code>protected</code>,
     * <code>private</code>, <code>final</code>, <code>static</code>,
     * <code>abstract</code> and <code>interface</code>; they should be decoded
     * using the methods of class <code>Modifier</code>.
     *
     * <p> If the underlying class is an array class, then its
     * <code>public</code>, <code>private</code> and <code>protected</code>
     * modifiers are the same as those of its component type.  If this
     * <code>Class</code> represents a primitive type or void, its
     * <code>public</code> modifier is always <code>true</code>, and its
     * <code>protected</code> and <code>private</code> modifiers are always
     * <code>false</code>. If this object represents an array class, a
     * primitive type or void, then its <code>final</code> modifier is always
     * <code>true</code> and its interface modifier is always
     * <code>false</code>. The values of its other modifiers are not determined
     * by this specification.
     *
     * <p> The modifier encodings are defined in <em>The Java Virtual Machine
     * Specification</em>, table 4.1.
     *
     * @return the <code>int</code> representing the modifiers for this class
     * @see     java.lang.reflect.Modifier
     * @since JDK1.1
     */
    public function getModifiers(){
        return $this->reflectionClass->getModifiers();
    }

    /**
     * Returns the simple name of the underlying class as given in the
     * source code. Returns an empty string if the underlying class is
     * anonymous.
     *
     * <p>The simple name of an array is the simple name of the
     * component type with "[]" appended.  In particular the simple
     * name of an array whose component type is anonymous is "[]".
     *
     * @return blaze\lang\String the simple name of the underlying class
     * @since 1.5
     */
    public function getSimpleName(){
        return new String($this->reflectionClass->getShortName());
    }

    /**
     * Returns the canonical name of the underlying class as
     * defined by the Java Language Specification.  Returns null if
     * the underlying class does not have a canonical name (i.e., if
     * it is a local or anonymous class or an array whose component
     * type does not have a canonical name).
     * @return the canonical name of the underlying class if it exists, and
     * <tt>null</tt> otherwise.
     * @since 1.5
     */
    public function getFileName(){
        return new String($this->reflectionClass->getFileName());
    }

    /**
     * Returns an array containing <code>Field</code> objects reflecting all
     * the accessible public fields of the class or interface represented by
     * this <code>Class</code> object.  The elements in the array returned are
     * not sorted and are not in any particular order.  This method returns an
     * array of length 0 if the class or interface has no accessible public
     * fields, or if it represents an array class, a primitive type, or void.
     *
     * <p> Specifically, if this <code>Class</code> object represents a class,
     * this method returns the public fields of this class and of all its
     * superclasses.  If this <code>Class</code> object represents an
     * interface, this method returns the fields of this interface and of all
     * its superinterfaces.
     *
     * <p> The implicit length field for array class is not reflected by this
     * method. User code should use the methods of class <code>Array</code> to
     * manipulate arrays.
     *
     * <p> See <em>The Java Language Specification</em>, sections 8.2 and 8.3.
     *
     * @return array[blaze\lang\reflect\Field] the array of <code>Field</code> objects representing the
     * public fields
     * @exception  SecurityException
     *             If a security manager, <i>s</i>, is present and any of the
     *             following conditions is met:
     *
     *             <ul>
     *
     *             <li> invocation of
     *             <tt>{@link SecurityManager#checkMemberAccess
     *             s.checkMemberAccess(this, Member.PUBLIC)}</tt> denies
     *             access to the fields within this class
     *
     *             <li> the caller's class loader is not the same as or an
     *             ancestor of the class loader for the current class and
     *             invocation of <tt>{@link SecurityManager#checkPackageAccess
     *             s.checkPackageAccess()}</tt> denies access to the package
     *             of this class
     *
     *             </ul>
     *
     * @since JDK1.1
     */
    public function getFields(){
        $props = $this->reflectionClass->getProperties();
        $arr = array();
        foreach($props as $prop){
            $arr[] = new Field($prop);
        }
        return $arr;
    }

    /**
     * Returns an array containing <code>Method</code> objects reflecting all
     * the public <em>member</em> methods of the class or interface represented
     * by this <code>Class</code> object, including those declared by the class
     * or interface and those inherited from superclasses and
     * superinterfaces.  Array classes return all the (public) member methods
     * inherited from the <code>Object</code> class.  The elements in the array
     * returned are not sorted and are not in any particular order.  This
     * method returns an array of length 0 if this <code>Class</code> object
     * represents a class or interface that has no public member methods, or if
     * this <code>Class</code> object represents a primitive type or void.
     *
     * <p> The class initialization method <code>&lt;clinit&gt;</code> is not
     * included in the returned array. If the class declares multiple public
     * member methods with the same parameter types, they are all included in
     * the returned array.
     *
     * <p> See <em>The Java Language Specification</em>, sections 8.2 and 8.4.
     *
     * @return blaze\util\ArrayObject the array of <code>Method</code> objects representing the
     * public methods of this class
     * @exception  SecurityException
     *             If a security manager, <i>s</i>, is present and any of the
     *             following conditions is met:
     *
     *             <ul>
     *
     *             <li> invocation of
     *             <tt>{@link SecurityManager#checkMemberAccess
     *             s.checkMemberAccess(this, Member.PUBLIC)}</tt> denies
     *             access to the methods within this class
     *
     *             <li> the caller's class loader is not the same as or an
     *             ancestor of the class loader for the current class and
     *             invocation of <tt>{@link SecurityManager#checkPackageAccess
     *             s.checkPackageAccess()}</tt> denies access to the package
     *             of this class
     *
     *             </ul>
     *
     * @since JDK1.1
     */
    public function getMethods(){
        $methods = $this->reflectionClass->getMethods();
        $arr = array();
        foreach($methods as $prop){
            $arr[] = new Method($prop);
        }
        return $arr;
    }

    public function getConstants(){
        $constants = $this->reflectionClass->getConstants();
        $arr = array();
        foreach($constants as $prop){
            $arr[] = new Method($prop);
        }
        return $arr;
    }


    /**
     * Returns a <code>Field</code> object that reflects the specified public
     * member field of the class or interface represented by this
     * <code>Class</code> object. The <code>name</code> parameter is a
     * <code>String</code> specifying the simple name of the desired field.
     *
     * <p> The field to be reflected is determined by the algorithm that
     * follows.  Let C be the class represented by this object:
     * <OL>
     * <LI> If C declares a public field with the name specified, that is the
     *      field to be reflected.</LI>
     * <LI> If no field was found in step 1 above, this algorithm is applied
     * 	    recursively to each direct superinterface of C. The direct
     * 	    superinterfaces are searched in the order they were declared.</LI>
     * <LI> If no field was found in steps 1 and 2 above, and C has a
     *      superclass S, then this algorithm is invoked recursively upon S.
     *      If C has no superclass, then a <code>NoSuchFieldException</code>
     *      is thrown.</LI>
     * </OL>
     *
     * <p> See <em>The Java Language Specification</em>, sections 8.2 and 8.3.
     *
     * @param name the field name
     * @return  the <code>Field</code> object of this class specified by
     * <code>name</code>
     * @exception NoSuchFieldException if a field with the specified name is
     *              not found.
     * @exception NullPointerException if <code>name</code> is <code>null</code>
     * @exception  SecurityException
     *             If a security manager, <i>s</i>, is present and any of the
     *             following conditions is met:
     *
     *             <ul>
     *
     *             <li> invocation of
     *             <tt>{@link SecurityManager#checkMemberAccess
     *             s.checkMemberAccess(this, Member.PUBLIC)}</tt> denies
     *             access to the field
     *
     *             <li> the caller's class loader is not the same as or an
     *             ancestor of the class loader for the current class and
     *             invocation of <tt>{@link SecurityManager#checkPackageAccess
     *             s.checkPackageAccess()}</tt> denies access to the package
     *             of this class
     *
     *             </ul>
     *
     * @since JDK1.1
     */
    public function getField($name){
        if($name instanceof String)
            return new Field($this->reflectionClass->getProperty($name->toNative()));
        else
            return new Field($this->reflectionClass->getProperty($name));
    }

    /**
     * Returns a <code>Method</code> object that reflects the specified public
     * member method of the class or interface represented by this
     * <code>Class</code> object. The <code>name</code> parameter is a
     * <code>String</code> specifying the simple name of the desired method. The
     * <code>parameterTypes</code> parameter is an array of <code>Class</code>
     * objects that identify the method's formal parameter types, in declared
     * order. If <code>parameterTypes</code> is <code>null</code>, it is
     * treated as if it were an empty array.
     *
     * <p> If the <code>name</code> is "{@code <init>};"or "{@code <clinit>}" a
     * <code>NoSuchMethodException</code> is raised. Otherwise, the method to
     * be reflected is determined by the algorithm that follows.  Let C be the
     * class represented by this object:
     * <OL>
     * <LI> C is searched for any <I>matching methods</I>. If no matching
     * 	    method is found, the algorithm of step 1 is invoked recursively on
     * 	    the superclass of C.</LI>
     * <LI> If no method was found in step 1 above, the superinterfaces of C
     *      are searched for a matching method. If any such method is found, it
     *      is reflected.</LI>
     * </OL>
     *
     * To find a matching method in a class C:&nbsp; If C declares exactly one
     * public method with the specified name and exactly the same formal
     * parameter types, that is the method reflected. If more than one such
     * method is found in C, and one of these methods has a return type that is
     * more specific than any of the others, that method is reflected;
     * otherwise one of the methods is chosen arbitrarily.
     *
     * <p>Note that there may be more than one matching method in a
     * class because while the Java language forbids a class to
     * declare multiple methods with the same signature but different
     * return types, the Java virtual machine does not.  This
     * increased flexibility in the virtual machine can be used to
     * implement various language features.  For example, covariant
     * returns can be implemented with {@linkplain
     * java.lang.reflect.Method#isBridge bridge methods}; the bridge
     * method and the method being overridden would have the same
     * signature but different return types.
     *
     * <p> See <em>The Java Language Specification</em>, sections 8.2 and 8.4.
     *
     * @param name the name of the method
     * @param parameterTypes the list of parameters
     * @return blaze\lang\reflect\Method the <code>Method</code> object that matches the specified
     * <code>name</code> and <code>parameterTypes</code>
     * @exception NoSuchMethodException if a matching method is not found
     *            or if the name is "&lt;init&gt;"or "&lt;clinit&gt;".
     * @exception NullPointerException if <code>name</code> is <code>null</code>
     * @exception  SecurityException
     *             If a security manager, <i>s</i>, is present and any of the
     *             following conditions is met:
     *
     *             <ul>
     *
     *             <li> invocation of
     *             <tt>{@link SecurityManager#checkMemberAccess
     *             s.checkMemberAccess(this, Member.PUBLIC)}</tt> denies
     *             access to the method
     *
     *             <li> the caller's class loader is not the same as or an
     *             ancestor of the class loader for the current class and
     *             invocation of <tt>{@link SecurityManager#checkPackageAccess
     *             s.checkPackageAccess()}</tt> denies access to the package
     *             of this class
     *
     *             </ul>
     *
     * @since JDK1.1
     */
    public function getMethod($name) {
        if($name instanceof String)
            return new Method($this->reflectionClass->getMethod($name->toNative()));
        else
            return new Method($this->reflectionClass->getMethod($name));
    }

    public function getConstant($name) {
        if($name instanceof String)
            return new Method($this->reflectionClass->getConstant($name->toNative()));
        else
            return new Method($this->reflectionClass->getConstant($name));
    }

    /**
     * Returns a <code>Constructor</code> object that reflects the specified
     * public constructor of the class represented by this <code>Class</code>
     * object. The <code>parameterTypes</code> parameter is an array of
     * <code>Class</code> objects that identify the constructor's formal
     * parameter types, in declared order.
     *
     * If this <code>Class</code> object represents an inner class
     * declared in a non-static context, the formal parameter types
     * include the explicit enclosing instance as the first parameter.
     *
     * <p> The constructor to reflect is the public constructor of the class
     * represented by this <code>Class</code> object whose formal parameter
     * types match those specified by <code>parameterTypes</code>.
     *
     * @param parameterTypes the parameter array
     * @return blaze\lang\reflect\Method the <code>Constructor</code> object of the public constructor that
     * matches the specified <code>parameterTypes</code>
     * @exception NoSuchMethodException if a matching method is not found.
     * @exception  SecurityException
     *             If a security manager, <i>s</i>, is present and any of the
     *             following conditions is met:
     *
     *             <ul>
     *
     *             <li> invocation of
     *             <tt>{@link SecurityManager#checkMemberAccess
     *             s.checkMemberAccess(this, Member.PUBLIC)}</tt> denies
     *             access to the constructor
     *
     *             <li> the caller's class loader is not the same as or an
     *             ancestor of the class loader for the current class and
     *             invocation of <tt>{@link SecurityManager#checkPackageAccess
     *             s.checkPackageAccess()}</tt> denies access to the package
     *             of this class
     *
     *             </ul>
     *
     * @since JDK1.1
     */
    public function getConstructor(){
        return new Method($this->reflectionClass->getConstructor());
    }

    /**
 * Finds a resource with a given name.  The rules for searching resources
 * associated with a given class are implemented by the defining
 * {@linkplain ClassLoader class loader} of the class.  This method
 * delegates to this object's class loader.  If this object was loaded by
 * the bootstrap class loader, the method delegates to {@link
 * ClassLoader#getSystemResourceAsStream}.
 *
 * <p> Before delegation, an absolute resource name is constructed from the
 * given resource name using this algorithm:
 *
 * <ul>
 *
 * <li> If the <tt>name</tt> begins with a <tt>'/'</tt>
 * (<tt>'&#92;u002f'</tt>), then the absolute name of the resource is the
 * portion of the <tt>name</tt> following the <tt>'/'</tt>.
 *
 * <li> Otherwise, the absolute name is of the following form:
 *
 * <blockquote><pre>
 *   <tt>modified_package_name</tt>/<tt>name</tt>
 * </pre></blockquote>
 *
 * <p> Where the <tt>modified_package_name</tt> is the package name of this
 * object with <tt>'/'</tt> substituted for <tt>'.'</tt>
 * (<tt>'&#92;u002e'</tt>).
 *
 * </ul>
 *
 * @param blaze\lang\String|string $name name of the desired resource
 * @return      A {@link java.io.InputStream} object or <tt>null</tt> if
 *              no resource with this name is found
 * @throws  NullPointerException If <tt>name</tt> is <tt>null</tt>
 * @since  JDK1.1
 */
    public function getResourceAsStream($name){
        if($name instanceof String)
            return ClassLoader::getInstance()->getRessourceAsStream($name);
        else
            return ClassLoader::getInstance()->getRessourceAsStream(new String($name));
    }

     /**
     * Finds a resource with a given name.  The rules for searching resources
     * associated with a given class are implemented by the defining
     * {@linkplain ClassLoader class loader} of the class.  This method
     * delegates to this object's class loader.  If this object was loaded by
     * the bootstrap class loader, the method delegates to {@link
     * ClassLoader#getSystemResource}.
     *
     * <p> Before delegation, an absolute resource name is constructed from the
     * given resource name using this algorithm:
     *
     * <ul>
     *
     * <li> If the <tt>name</tt> begins with a <tt>'/'</tt>
     * (<tt>'&#92;u002f'</tt>), then the absolute name of the resource is the
     * portion of the <tt>name</tt> following the <tt>'/'</tt>.
     *
     * <li> Otherwise, the absolute name is of the following form:
     *
     * <blockquote><pre>
     *   <tt>modified_package_name</tt>/<tt>name</tt>
     * </pre></blockquote>
     *
     * <p> Where the <tt>modified_package_name</tt> is the package name of this
     * object with <tt>'/'</tt> substituted for <tt>'.'</tt>
     * (<tt>'&#92;u002e'</tt>).
     *
     * </ul>
     *
     * @param blaze\lang\String|string $name name of the desired resource
     * @return      A  {@link java.net.URL} object or <tt>null</tt> if no
     *              resource with this name is found
     * @since  JDK1.1
     */
    public function getResource($name){
        if($name instanceof String)
            return ClassLoader::getInstance()->getResource($name);
        else
            return ClassLoader::getInstance()->getResource(new String($name));
    }

    /**
     * Returns true if and only if this class was declared as an enum in the
     * source code.
     *
     * @return true if and only if this class was declared as an enum in the
     *     source code
     * @since 1.5
     */
    public function isEnum(){
        return $this->reflectionClass->isSubclassOf('blaze\lang\Enum');
    }

    /**
     * Returns the elements of this enum class or null if this
     * Class object does not represent an enum type.
     *
     * @return an array containing the values comprising the enum class
     *     represented by this Class object in the order they're
     *     declared, or null if this Class object does not
     *     represent an enum type
     * @since 1.5
     */
    public function getEnumConstants(){
        if(!$this->isEnum())
            return null;
        return $this->reflectionClass->getConstants();
    }

    /**
     * Casts an object to the class or interface represented
     * by this <tt>Class</tt> object.
     *
     * @param obj the object to be cast
     * @return blaze\lang\Object the object after casting, or null if obj is null
     *
     * @throws ClassCastException if the object is not
     * null and is not assignable to the type T.
     *
     * @since 1.5
     */
    public function cast(Object $obj){
        if(!$this->reflectionClass->isInstance($obj))
            throw new ClassCastException();
        return $obj;
    }

    /**
     *
     * @return array
     */
    public function getAnnotations(){
        $annotations = array();

        if (preg_match_all('/@(?P<name>[A-Za-z_-]+)(?:[ \t]+(?P<value>.*?))?[ \t]*\r?$/m', $this->reflectionClass->getDocComment(), $matches)) {
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
