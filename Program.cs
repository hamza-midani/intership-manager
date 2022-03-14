namespace Knight_Move
{
    class Progra
    {

       
        public class Node

        {
            public int x;
            public int y;
            public int dist;
            public Node(int x, int y)
            {
                this.x = x;
                this.y = y;
            }
            public Node(int x, int y, int dist)
            {
                this.x = x;
                this.y = y;
                this.dist = dist;
            }
            public bool equals(object obj)
            {
                if (this == obj)
                {
                    return true;
                }
                if (obj == null || this.GetType() != obj.GetType())
                {
                    return false;
                }
                else
                {
                    Node node = (Node)obj;
                    return this.x == node.x && this.y == node.y && this.dist == node.dist;

                }
            }
            public override int GetHashCode()
            {
                return x ^ y ^ dist;
            }

            public class knightMove
            {
                static int[] row = { 2, 2, -2, -2, 1, 1, -1, -1 };
                static int[] col = { -1, 1, 1, -1, 2, -2, 2, -2 };

                private static bool isValid(int xk, int yk, int N)
                {
                    return (xk >= 0 && xk < N) && (yk >= 0 && yk < N);
                }
                public static int KnightShortDistance(Node src, Node dest, int N)
                {
                    ISet<Node> visited = new HashSet<Node>();
                    Queue<Node> q = new Queue<Node>();
                    q.Enqueue(src);
                    while (q.Count > 0)
                    {

                        Node node = q.Dequeue();
                        int x = node.x;
                        int y = node.y;
                        int dist = node.dist;
                        
                        if (x == dest.x && y == dest.y)
                        {
                            return dist;
                        }
                        
                        if (!visited.Contains(node))
                        {
                            
                            visited.Add(node);
                            
                            for (int i = 0; i < row.Length; i++)
                            {
                                var xk1 = x + row[i];
                                var yk1 = y + col[i];
                                if (isValid(xk1, yk1, N))
                                {
                                    q.Enqueue(new Node(xk1, yk1, dist + 1));

                                }
                            }
                        }
                    }
                    return int.MaxValue;

                }


            }
        }
        private static void destination(out int a, out int b)
        {
            Console.Write("number of rows for target =");
            a = Int16.Parse(Console.ReadLine());
            Console.Write("number of cols for target =");
            b = Int16.Parse(Console.ReadLine());
        }

        private static void source(out int x, out int y)
        {
            Console.Write("number of rows for knight =");
            x = Int16.Parse(Console.ReadLine());
            Console.Write("number of rows for knight =");
            y = Int16.Parse(Console.ReadLine());
        }
        private static void inserstion(string[,] tab)
        {
            for (int i = 0; i < tab.GetLength(0); i++)
            {
                for (int j = 0; j < tab.GetLength(1); j++)
                {
                    tab[i, j] = " ";
                }
            }

        }
        private static void affichage(string[,] tab)
        {
            for (int i = 0; i < tab.GetLength(0); i++)
            {

                for (int j = 0; j < tab.GetLength(1); j++)
                {
                    Console.Write("[" + tab[i, j] + "]");
                }
                Console.WriteLine("");
            }
        }
        private static void Bord(out int n, out int m)
        {
            Console.Write("number of rows for bord =");
            n = Int16.Parse(Console.ReadLine());
            Console.Write("number of columns for bord =");
            m = Int16.Parse(Console.ReadLine());
        }

        static void Main(string[] args)
        {
            int x, y;
            int a, b;
            int n, m;
            int N = 100000000;
            Bord(out n, out m);
            string[,] tabNotes = new string[n, m];
            inserstion(tabNotes);
            //position de knight
            source(out x, out y);
            Node src = new Node(x, y);
            tabNotes[x, y] = "K";
            // positin de target
            destination(out a, out b);
            Node dest = new Node(a, b);
            tabNotes[a, b] = "T";
            affichage(tabNotes);

            Console.WriteLine("The minimum number of steps required is " + Node.knightMove.KnightShortDistance(src, dest, N));
        }

       

    }
}
