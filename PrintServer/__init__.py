from flask import Flask
from flask_cors import CORS
from routes import Router
import Constants


def main():
    print('Starting Server')
    app = Flask(__name__)
    cors = CORS(app, resources={r"/*": {"origins": "*"}})
    router = Router.Router(app)
    router.manage_routes()
    app.run(host=Constants.HOST, port=Constants.PORT)


if __name__ == '__main__':
    main()
