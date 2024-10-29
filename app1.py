from flask import Flask, render_template, redirect, url_for, request, session, flash
from models import db, User, Product, Cart, CartItem, Order, ContactMessage
from flask_wtf import FlaskForm
from wtforms import StringField, PasswordField, SubmitField, TextAreaField
from wtforms.validators import InputRequired, Email, Length
from werkzeug.security import generate_password_hash, check_password_hash
from flask_migrate import Migrate

# Initialize the Flask application
app = Flask(__name__)

# Configurations
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///database.db'
app.config['SECRET_KEY'] = 'mysecretkey'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

# Initialize the database and migration
db.init_app(app)
migrate = Migrate(app, db)

# Create tables on the first request using _got_first_request
@app.before_request
def initialize_db():
    if not hasattr(app, 'db_initialized'):
        with app.app_context():
            db.create_all()
        app.db_initialized = True

# WTForms for login, register, and contact
class LoginForm(FlaskForm):
    username = StringField('Username', validators=[InputRequired(), Length(min=4, max=150)])
    password = PasswordField('Password', validators=[InputRequired(), Length(min=4, max=150)])
    submit = SubmitField('Login')

class RegisterForm(FlaskForm):
    username = StringField('Username', validators=[InputRequired(), Length(min=4, max=150)])
    email = StringField('Email', validators=[InputRequired(), Email(), Length(max=150)])
    password = PasswordField('Password', validators=[InputRequired(), Length(min=4, max=150)])
    submit = SubmitField('Register')

class ContactForm(FlaskForm):
    name = StringField('Name', validators=[InputRequired(), Length(min=2, max=100)])
    email = StringField('Email', validators=[InputRequired(), Email(), Length(max=150)])
    message = TextAreaField('Message', validators=[InputRequired(), Length(min=10)])
    submit = SubmitField('Submit')

# Routes
@app.route('/')
def index():
    products = Product.query.all()
    return render_template('index.html', products=products)

@app.route('/register', methods=['GET', 'POST'])
def register():
    form = RegisterForm()
    if form.validate_on_submit():
        hashed_password = generate_password_hash(form.password.data, method='sha256')
        new_user = User(username=form.username.data, email=form.email.data, password=hashed_password)
        db.session.add(new_user)
        db.session.commit()
        flash('Registration Successful!', 'success')
        return redirect(url_for('login'))
    return render_template('register.html', form=form)

@app.route('/login', methods=['GET', 'POST'])
def login():
    form = LoginForm()
    if form.validate_on_submit():
        user = User.query.filter_by(username=form.username.data).first()
        if user and check_password_hash(user.password, form.password.data):
            session['user_id'] = user.id
            flash('Login Successful!', 'success')
            return redirect(url_for('index'))
        else:
            flash('Invalid Credentials', 'danger')
    return render_template('login.html', form=form)

@app.route('/cart')
def cart():
    if 'user_id' not in session:
        flash('Please login first', 'danger')
        return redirect(url_for('login'))

    user_id = session['user_id']
    user_cart = Cart.query.filter_by(user_id=user_id).first()

    if not user_cart:
        user_cart = Cart(user_id=user_id)
        db.session.add(user_cart)
        db.session.commit()

    cart_items = CartItem.query.filter_by(cart_id=user_cart.id).all()
    return render_template('cart.html', cart_items=cart_items)

@app.route('/add_to_cart/<int:product_id>')
def add_to_cart(product_id):
    if 'user_id' not in session:
        flash('Please login first', 'danger')
        return redirect(url_for('login'))

    user_id = session['user_id']
    user_cart = Cart.query.filter_by(user_id=user_id).first()

    if not user_cart:
        user_cart = Cart(user_id=user_id)
        db.session.add(user_cart)
        db.session.commit()

    product = Product.query.get_or_404(product_id)
    cart_item = CartItem.query.filter_by(cart_id=user_cart.id, product_id=product.id).first()

    if cart_item:
        cart_item.quantity += 1
    else:
        cart_item = CartItem(cart_id=user_cart.id, product_id=product.id, quantity=1)
        db.session.add(cart_item)

    db.session.commit()
    flash(f'{product.name} added to your cart!', 'success')
    return redirect(url_for('index'))

@app.route('/checkout')
def checkout():
    if 'user_id' not in session:
        flash('Please login first', 'danger')
        return redirect(url_for('login'))

    user_id = session['user_id']
    user_cart = Cart.query.filter_by(user_id=user_id).first()

    cart_items = CartItem.query.filter_by(cart_id=user_cart.id).all()

    total_amount = sum(item.product.price * item.quantity for item in cart_items)

    new_order = Order(user_id=user_id, total_amount=total_amount)
    db.session.add(new_order)
    db.session.commit()

    db.session.delete(user_cart)
    db.session.commit()

    flash('Order Placed Successfully!', 'success')
    return redirect(url_for('index'))

# Contact form route
@app.route('/contact', methods=['GET', 'POST'])
def contact():
    form = ContactForm()
    if form.validate_on_submit():
        new_message = ContactMessage(
            name=form.name.data,
            email=form.email.data,
            message=form.message.data
        )
        db.session.add(new_message)
        db.session.commit()
        flash('Message sent successfully!', 'success')
        return redirect(url_for('index'))
    return render_template('contact.html', form=form)

# View messages route
@app.route('/messages')
def view_messages():
    messages = ContactMessage.query.all()
    return render_template('view_messages.html', messages=messages)

if __name__ == '__main__':
    app.run(debug=True)
