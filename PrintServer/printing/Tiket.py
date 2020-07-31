from escpos.printer import Usb
from datetime import datetime
import json

class tiket():

    def __init__(self):
        # self.z_printer = zebra.zebra(Constants.PRINTER_NAME)
        self.p = Usb(0x0416, 0x5011, 0, 0x81, 0x03)
    def print_ticket(self,data):
        # Adapt to your needs
        #p = Usb(0x0416, 0x5011, profile="POS-5890")
        p = self.p

        # tiket title
        p.set(align='center', text_type='B', width=2, height=1)
        p.text('EL RACONET\n')
        p.set(align='center',text_type='NORMAL', width=1, height=1)
        p.text('NIE: X1443024-G\n')
        p.text('MOLTES GRACIES\n')
        p.text('IVA INCLOS\n')
        p.text('\n')

        # tiket date
        p.set(align='LEFT')
        now = datetime.now()
        dias = ("LUN","MAR","MIE","JUE","VIE","SAB","DOM")
        week = dias[now.weekday()]
        format = now.strftime('FECHA %d/%m/%Y {}  HORA %H:%M').format(week)
        p.text(format + '\n')
        p.text('\n')

        # tiket item
        #items = [{"name": "fant", "price": "1.70"},{"name": "fantsssasss", "price": "1.70"},{"name": "fantasss", "price": "1.70"}]
        items = data["items"]
        for item in items:
            space = 32 - len(item["price_producto"])
            if item["quantity"] > 1:
                p.text(str(item["quantity"])+"X".ljust(15) +"@" +str(item["price_producto"]) + "\n" )
                price = '%.2f' % (float(item["price_producto"]) * item["quantity"])
                space = 32 - len(str(price)) 
                p.text(item["name"].ljust(space) + str(price) + '\n')
            else:
                p.text(item["name"].ljust(space) +str(item["price_producto"]) + '\n')
            #print(item["name"].ljust(space) +str(item["price"]))

        # tiket result
        p.set(text_type='B', width=2, height=1)
        #total = "8.00"
        total = data["price_all"]
        space = 16 - len(total)
        p.text("TOTAL".ljust(space) + str(total)+ '\n')
        #print("TOTAL".ljust(space) + str(total))

        p.text("\n\n")