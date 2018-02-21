import serial

# Not sure if these are constants
PORT_NAME = '/dev/cu.usbmodem1411'
PORT_NUM = 9600


class SerialMonitor:
    def __init__(self, port_name: str = PORT_NAME, port_num: int = PORT_NUM, *args, **kwargs):
        self.serialData = serial.Serial(port_name, port_num)

    def read(self) -> bytes:
        if (self.serialData.inWaiting() > 0):
            return self.serialData.readline()
        return None
    
    def readNum(self):
        data = self.read()

        try:
            return float(data)
        except:
            return -1

def main():
    m = SerialMonitor()
    while (True):
        text = m.read()

        if text is not None:
            try:
                print(float(text))
            finally:
                pass

if __name__ == '__main__':
    main()