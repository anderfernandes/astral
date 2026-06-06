import { JSX } from "@solidjs/web";

interface IDialogProps {
  title?: JSX.Element;
  subtitle?: JSX.Element;
  children?: JSX.Element;
  footer?: JSX.Element;
}

export function Dialog(props: IDialogProps) {
  const { title, subtitle, children, footer } = props;

  return (
    <dialog class="fixed top-0 left-0 flex h-svh w-svw items-center justify-center bg-black/50">
      <div class="relative w-96 transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <h5 class="text-base/7 font-medium">{title}</h5>
          <h6 class="mb-2 text-sm/6 text-gray-500">{subtitle}</h6>
          {children}
        </div>
        <div class="grid gap-3 bg-gray-50 px-4 py-3 sm:px-6 lg:flex lg:flex-row-reverse">
          {footer}
        </div>
      </div>
    </dialog>
  );
}
